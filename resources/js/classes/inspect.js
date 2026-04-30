import token from "../auth/token.js";

const url_link = window.location.pathname.split("/");
const class_id = url_link.pop();

let currentClassData = null;
let teacherDebounce = null;

document.addEventListener("DOMContentLoaded", () => {
    const portal = document.getElementById("teacher-results");
    if (portal) document.body.appendChild(portal);

    loadClassDetails();
    initInlineEdit();
});

function show(id, displayClass = null) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove("hidden");
    if (displayClass) el.classList.add(displayClass);
}

function hide(id, displayClass = null) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.add("hidden");
    if (displayClass) el.classList.remove(displayClass);
}

function authHeaders() {
    return {
        "X-Requested-With": "XMLHttpRequest",
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
    };
}

async function apiFetch(path, options = {}) {
    const res = await fetch(`/api/v1/${path}`, {
        method: "GET",
        headers: authHeaders(),
        ...options,
    });
    if (!res.ok) throw new Error(`API ${res.status}`);
    const json = await res.json();
    return json.data ?? json;
}

async function loadClassDetails() {
    try {
        const classData = await apiFetch(`school_classes/${class_id}`);
        currentClassData = classData;

        const [subjectData, levelData] = await Promise.all([
            fetchDetail("subjects", classData.subject_id),
            fetchDetail("levels", classData.level_id),
        ]);

        renderCard(classData, subjectData, levelData);
        renderStudents(classData.inscriptions || []);
    } catch (e) {
        console.error("Erreur chargement détails classe:", e);
    }
}

async function fetchDetail(resource, id) {
    if (!id) return null;
    try {
        return await apiFetch(`${resource}/${id}`);
    } catch {
        return null;
    }
}

function renderCard(schoolClass, subject, level) {
    document.getElementById("class-name").textContent =
        schoolClass.name.toUpperCase();
    document.getElementById("class-subject").textContent =
        subject?.name || "Matière non définie";
    document.getElementById("level-name").textContent =
        level?.name || "Niveau non défini";

    document.getElementById("student-count").textContent = (
        schoolClass.nbr_students ?? 0
    )
        .toString()
        .padStart(2, "0");

    const user = schoolClass.teacher?.user || {};
    document.getElementById("teacher-name").textContent =
        `${user.prenom || ""} ${user.nom || "Enseignant"}`;
    document.getElementById("teacher-email").textContent =
        user.email || "Non renseigné";
    document.getElementById("teacher-avatar").src = user.photo
        ? `/storage/${user.photo}`
        : `/images/default.jpeg`;
}

function renderStudents(inscriptions) {
    const container = document.getElementById("students-list");
    const template = document.getElementById("student-row-template");
    if (!container || !template) return;
    container.replaceChildren();

    if (!inscriptions.length) {
        const row = document.createElement("tr");
        const cell = document.createElement("td");
        cell.colSpan = 2;
        cell.className =
            "p-12 text-center text-gray-600 text-[10px] font-black uppercase tracking-widest";
        cell.textContent = "Aucune inscription";
        row.appendChild(cell);
        container.appendChild(row);
        return;
    }

    inscriptions.forEach((ins) => {
        const student = ins.student?.user || {};
        const clone = template.content.cloneNode(true);
        clone.querySelector(".student-photo").src = student.photo
            ? `/storage/${student.photo}`
            : "/images/default.jpeg";
        clone.querySelector(".student-name").textContent =
            `${student.prenom || ""} ${student.nom || ""}`;
        clone.querySelector(".student-link").href =
            `/administration/students/${ins.id}`;
        container.appendChild(clone);
    });
}

function initInlineEdit() {
    document
        .getElementById("btn-edit")
        .addEventListener("click", enterEditMode);
    document
        .getElementById("btn-cancel")
        .addEventListener("click", exitEditMode);
    document.getElementById("btn-save").addEventListener("click", submitEdit);

    document.getElementById("teacher-search").addEventListener("input", (e) => {
        clearTimeout(teacherDebounce);
        document.getElementById("selected-teacher-id").value = "";
        const q = e.target.value.trim();
        if (!q) {
            hide("teacher-results");
            return;
        }
        teacherDebounce = setTimeout(() => searchTeachers(q), 350);
    });

    document.addEventListener("click", (e) => {
        if (
            !e.target.closest("#teacher-search-anchor") &&
            !e.target.closest("#teacher-results")
        ) {
            hide("teacher-results");
        }
    });

    window.addEventListener("scroll", alignPortal, { passive: true });
    window.addEventListener("resize", alignPortal, { passive: true });
}

function enterEditMode() {
    if (!currentClassData) return;

    document.getElementById("edit-class-name").value =
        currentClassData.name || "";
    const user = currentClassData.teacher?.user || {};
    document.getElementById("teacher-search").value =
        `${user.prenom || ""} ${user.nom || ""}`.trim().toUpperCase();
    document.getElementById("selected-teacher-id").value =
        currentClassData.teacher?.id || "";

    hide("class-name");
    show("edit-class-name");
    hide("teacher-name");
    show("teacher-search-wrap");

    hide("btn-edit", "inline-flex");
    show("btn-save", "inline-flex");
    show("btn-cancel", "inline-flex");

    document
        .getElementById("class-card")
        .classList.replace("border-gray-800", "border-amber-500/30");
    hideFeedback();
}

function exitEditMode() {
    show("class-name");
    hide("edit-class-name");
    show("teacher-name");
    hide("teacher-search-wrap");
    hide("teacher-results");

    show("btn-edit", "inline-flex");
    hide("btn-save", "inline-flex");
    hide("btn-cancel", "inline-flex");

    document
        .getElementById("class-card")
        .classList.replace("border-amber-500/30", "border-gray-800");
    hideFeedback();
}

function alignPortal() {
    const anchor = document.getElementById("teacher-search-anchor");
    const portal = document.getElementById("teacher-results");
    if (!anchor || !portal || portal.classList.contains("hidden")) return;

    const rect = anchor.getBoundingClientRect();
    portal.style.top = `${rect.bottom + 6}px`;
    portal.style.left = `${rect.left}px`;
    portal.style.width = `${rect.width}px`;
}

function showPortal() {
    alignPortal();
    show("teacher-results");
}

async function searchTeachers(query) {
    const portal = document.getElementById("teacher-results");

    portal.innerHTML = `
        <div class="px-4 py-3 flex items-center gap-2 text-[10px] text-gray-500 font-bold uppercase tracking-widest">
            <i class="fa-solid fa-spinner animate-spin text-amber-500"></i> Recherche...
        </div>`;
    showPortal();

    try {
        const res = await fetch(
            `/api/v1/teachers?search=${encodeURIComponent(query)}`,
            {
                method: "GET",
                headers: authHeaders(),
            },
        );
        if (!res.ok) throw new Error(`API ${res.status}`);

        const json = await res.json();
        const teachers = json.data ?? [];
        renderTeacherResults(teachers);
    } catch (e) {
        console.error("Erreur recherche enseignants:", e);
        portal.innerHTML = `
            <div class="px-4 py-3 text-[10px] text-red-400 font-bold uppercase tracking-widest">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i>Erreur de recherche
            </div>`;
    }
}

function renderTeacherResults(teachers) {
    const portal = document.getElementById("teacher-results");
    portal.innerHTML = "";

    if (!teachers.length) {
        portal.innerHTML = `
            <div class="px-4 py-3 text-[10px] text-gray-600 font-bold uppercase tracking-widest">
                Aucun résultat
            </div>`;
        return;
    }

    teachers.forEach((teacher) => {
        const user = teacher.user || {};
        const name = `${user.prenom || ""} ${user.nom || ""}`
            .trim()
            .toUpperCase();
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className =
            "w-full flex items-center gap-3 px-4 py-3 hover:bg-gray-700/60 transition-colors text-left group";
        btn.innerHTML = `
            <img src="${user.photo ? `/storage/${user.photo}` : "/images/default.jpeg"}" class="w-7 h-7 rounded-lg object-cover border border-gray-700 shrink-0">
            <div>
                <p class="text-[11px] font-black text-white group-hover:text-amber-500 transition-colors">${name}</p>
                <p class="text-[9px] text-gray-500 font-bold">${user.email || ""}</p>
            </div>`;
        btn.addEventListener("click", () => selectTeacher(teacher));
        portal.appendChild(btn);
    });
}

function selectTeacher(teacher) {
    const user = teacher.user || {};
    document.getElementById("teacher-search").value =
        `${user.prenom || ""} ${user.nom || ""}`.trim().toUpperCase();
    document.getElementById("selected-teacher-id").value = teacher.id;
    hide("teacher-results");
}

async function submitEdit() {
    const nameVal = document.getElementById("edit-class-name").value.trim();
    const teacherId = document.getElementById("selected-teacher-id").value;
    const saveBtn = document.getElementById("btn-save");
    const saveLbl = document.getElementById("btn-save-label");

    if (!nameVal) {
        showFeedback("Veuillez saisir un nom de classe.", "error");
        document.getElementById("edit-class-name").focus();
        return;
    }

    const searchVal = document.getElementById("teacher-search").value.trim();
    if (searchVal && !teacherId) {
        showFeedback(
            "Veuillez sélectionner un enseignant dans la liste.",
            "error",
        );
        document.getElementById("teacher-search").focus();
        return;
    }

    saveBtn.disabled = true;
    saveLbl.textContent = "Enregistrement...";
    hideFeedback();

    try {
        const body = { name: nameVal };
        if (teacherId) body.teacher_id = teacherId;

        const res = await fetch(`/api/v1/school_classes/${class_id}`, {
            method: "PUT",
            headers: { ...authHeaders(), "Content-Type": "application/json" },
            body: JSON.stringify(body),
        });

        if (!res.ok) {
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message || `Erreur ${res.status}`);
        }

        await loadClassDetails();
        exitEditMode();
        showFeedback("Modifications enregistrées ✓", "success");
        setTimeout(hideFeedback, 3000);
    } catch (e) {
        console.error("Erreur modification:", e);
        showFeedback(e.message || "Une erreur est survenue.", "error");
    } finally {
        saveBtn.disabled = false;
        saveLbl.textContent = "Enregistrer";
    }
}

function showFeedback(msg, type) {
    const el = document.getElementById("inline-feedback");
    el.textContent = msg;
    el.className = [
        "mt-4 px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest w-fit max-w-xs",
        type === "success"
            ? "bg-green-500/10 text-green-400 border border-green-500/20"
            : "bg-red-500/10 text-red-400 border border-red-500/20",
    ].join(" ");
}

function hideFeedback() {
    const el = document.getElementById("inline-feedback");
    el.className = "hidden";
    el.textContent = "";
}
