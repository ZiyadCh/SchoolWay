import token from "../auth/token.js";

const url_link = window.location.pathname.split("/");
const class_id = url_link.pop();

document.addEventListener("DOMContentLoaded", () => {
    loadClassDetails();
});

////////////////////////////
async function loadClassDetails() {
    try {
        const response = await fetch(`/api/v1/school_classes/${class_id}`, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                Authorization: `Bearer ${token}`,
            },
        });

        if (!response.ok) throw new Error("Classe introuvable");

        const result = await response.json();
        const classData = result.data || result;

        const [subjectData, levelData] = await Promise.all([
            fetchDetail("subjects", classData.subject_id),
            fetchDetail("levels", classData.level_id),
        ]);

        updateUI(classData, subjectData, levelData);
        renderStudents(classData.inscriptions || []);
        renderDevoirs(classData.devoirs || []);
    } catch (e) {
        console.error("Erreur chargement détails classe:", e);
    }
}

////////////////////////////
async function fetchDetail(resource, id) {
    if (!id) return null;
    try {
        const response = await fetch(`/api/v1/${resource}/${id}`, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                Authorization: `Bearer ${token}`,
            },
        });
        const result = await response.json();
        return result.data || result;
    } catch (e) {
        console.error(`Erreur fetch ${resource}:`, e);
        return null;
    }
}

////////////////////////////
function updateUI(schoolClass, subject, level) {
    document.getElementById("class-name").textContent =
        schoolClass.name.toUpperCase();
    document.getElementById("class-subject").textContent =
        subject?.name || "MATIÈRE NON DÉFINIE";
    document.getElementById("level-name").textContent =
        level?.name || "NIVEAU NON DÉFINI";
    document.getElementById("student-count").textContent = (
        schoolClass.inscriptions?.length || 0
    )
        .toString()
        .padStart(2, "0");

    if (schoolClass.teacher) {
        const teacher = schoolClass.teacher;
        const user = teacher.user || {};

        document.getElementById("teacher-name").textContent =
            `${user.prenom || ""} ${user.nom || "Enseignant"}`;
        document.getElementById("teacher-specialty").textContent =
            teacher.speciality || "Formateur Référent";
        document.getElementById("teacher-email").textContent =
            user.email || "Non renseigné";

        const avatarEl = document.getElementById("teacher-avatar");
        avatarEl.src = user.photo
            ? `/storage/${user.photo}`
            : `/images/default.jpeg`;
    }
}

////////////////////////////
function renderStudents(inscriptions) {
    const container = document.getElementById("students-list");
    container.innerHTML = "";

    if (inscriptions.length === 0) {
        container.innerHTML = `<tr><td colspan="2" class="p-12 text-center text-gray-600 text-[10px] font-black uppercase tracking-widest">Aucune inscription</td></tr>`;
        return;
    }

    inscriptions.forEach((ins) => {
        const student = ins.student?.user || {};
        const tr = document.createElement("tr");
        tr.className =
            "border-b border-gray-800/50 hover:bg-gray-800/10 transition-all group";
        tr.innerHTML = `
            <td class="px-8 py-5">
                <div class="flex items-center gap-4">
                    <img src="${student.photo ? "/storage/" + student.photo : "/images/default.jpeg"}" class="w-10 h-10 rounded-xl object-cover grayscale group-hover:grayscale-0 transition-all border border-gray-800">
                    <span class="text-sm font-bold text-gray-300 group-hover:text-amber-500 transition-colors uppercase">${student.prenom || ""} ${student.nom || ""}</span>
                </div>
            </td>
            <td class="px-8 py-5 text-right">
                <a href="/students/inspect/${ins.id}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-800 text-gray-500 hover:bg-amber-500 hover:text-black transition-all">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            </td>
        `;
        container.appendChild(tr);
    });
}

////////////////////////////
function renderDevoirs(devoirs) {
    const container = document.getElementById("devoirs-container");
    container.innerHTML = "";

    if (devoirs.length === 0) {
        container.innerHTML = `<p class="col-span-full text-center text-gray-600 text-[10px] font-black uppercase py-20 tracking-widest">Aucun travail en cours</p>`;
        return;
    }

    devoirs.forEach((d) => {
        const div = document.createElement("div");
        div.className =
            "bg-gray-900 border border-gray-800 p-8 rounded-3xl hover:border-amber-500/20 transition-all group";
        div.innerHTML = `
            <div class="flex justify-between items-start mb-6">
                <h4 class="text-[10px] font-black text-amber-500 uppercase tracking-widest">${d.title}</h4>
                <i class="fa-solid fa-file-signature text-gray-800 group-hover:text-amber-500/20 transition-colors"></i>
            </div>
            <p class="text-sm text-gray-400 leading-relaxed mb-6">${d.contenu}</p>
            <div class="flex items-center gap-2 pt-4 border-t border-gray-800">
                <i class="fa-regular fa-clock text-gray-600 text-[10px]"></i>
                <span class="text-[9px] font-black text-gray-500 uppercase">Échéance : ${new Date(d.deadline).toLocaleDateString("fr-FR")}</span>
            </div>
        `;
        container.appendChild(div);
    });
}

////////////////////////////
window.switchTab = function (event, tabId) {
    const contents = document.querySelectorAll(".tab-content");
    const buttons = document.querySelectorAll(".tab-btn");

    contents.forEach((c) => {
        c.classList.add("hidden");
        c.classList.remove("opacity-100");
    });

    const active = document.getElementById(tabId);
    active.classList.remove("hidden");
    setTimeout(() => active.classList.add("opacity-100"), 10);

    buttons.forEach((b) => {
        b.classList.remove("bg-amber-500", "text-black");
        b.classList.add("text-gray-500");
    });

    event.currentTarget.classList.add("bg-amber-500", "text-black");
    event.currentTarget.classList.remove("text-gray-500");
};
