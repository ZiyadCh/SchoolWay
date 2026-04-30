import token from "../auth/token.js";

const url_link = window.location.pathname.split("/");
const class_id = url_link.pop();

document.addEventListener("DOMContentLoaded", () => {
    loadClassDetails();
});

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
    } catch (e) {
        console.error("Erreur chargement détails classe:", e);
    }
}

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
        return null;
    }
}

function updateUI(schoolClass, subject, level) {
    document.getElementById("class-name").textContent =
        schoolClass.name.toUpperCase();
    document.getElementById("class-subject").textContent =
        subject?.name || "Matière non définie";
    document.getElementById("level-name").textContent =
        level?.name || "Niveau non défini";
    document.getElementById("student-count").textContent =
        schoolClass.nbr_students?.toString().padStart(2, "0") || "00";

    if (schoolClass.teacher) {
        const user = schoolClass.teacher.user || {};
        document.getElementById("teacher-name").textContent =
            `${user.prenom || ""} ${user.nom || "Enseignant"}`;
        document.getElementById("teacher-email").textContent =
            user.email || "Non renseigné";
        document.getElementById("teacher-avatar").src = user.photo
            ? `/storage/${user.photo}`
            : `/images/default.jpeg`;
    }
}

function renderStudents(inscriptions) {
    const container = document.getElementById("students-list");
    const template = document.getElementById("student-row-template");
    if (!container || !template) return;

    container.replaceChildren();

    if (inscriptions.length === 0) {
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

        const img = clone.querySelector(".student-photo");
        img.src = student.photo
            ? `/storage/${student.photo}`
            : "/images/default.jpeg";

        const name = clone.querySelector(".student-name");
        name.textContent = `${student.prenom || ""} ${student.nom || ""}`;

        const link = clone.querySelector(".student-link");
        link.href = `/administration/students/${ins.id}`;

        container.appendChild(clone);
    });
}
