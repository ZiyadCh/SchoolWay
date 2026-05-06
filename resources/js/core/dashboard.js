import getToken from "../auth/token.js";

document.addEventListener("DOMContentLoaded", () => {
    fetchDashboardData();
    setupManageButtons();
});

let levelsData = [];
let subjectsData = [];
let levelsEditMode = false;
let subjectsEditMode = false;

async function fetchDashboardData() {
    try {
        const headers = {
            Accept: "application/json",
            Authorization: `Bearer ${getToken()}`,
        };

        const [
            studentsRes,
            teachersRes,
            classesRes,
            paymentRes,
            levelsRes,
            subjectsRes,
            absencesRes,
        ] = await Promise.all([
            fetch("/api/v1/students?count", { headers }),
            fetch("/api/v1/teachers?count", { headers }),
            fetch("/api/v1/school_classes?count", { headers }),
            fetch("/api/v1/paiments/paiment-stats", { headers }),
            fetch("/api/v1/levels", { headers }),
            fetch("/api/v1/subjects", { headers }),
            fetch("/api/v1/absences?today=1", { headers }),
        ]);

        if (
            !studentsRes.ok ||
            !teachersRes.ok ||
            !classesRes.ok ||
            !paymentRes.ok ||
            !levelsRes.ok ||
            !subjectsRes.ok ||
            !absencesRes.ok
        ) {
            throw new Error("One or more requests failed");
        }

        const studentsData = await studentsRes.json();
        const teachersData = await teachersRes.json();
        const classesData = await classesRes.json();
        const paymentData = await paymentRes.json();
        levelsData = (await levelsRes.json()).data || [];
        subjectsData = (await subjectsRes.json()).data || [];
        const absencesData = await absencesRes.json();

        updateStatsCards(studentsData, teachersData, classesData, paymentData);
        renderLevels();
        renderSubjects();
        updateAbsencesList(absencesData);
    } catch (error) {
        console.error("Erreur lors du chargement du tableau de bord:", error);
        showErrorMessage();
    }
}

function updateStatsCards(
    studentsData,
    teachersData,
    classesData,
    paymentData,
) {
    document.getElementById("students-count").textContent =
        studentsData.total_students || 0;
    document.getElementById("teachers-count").textContent =
        teachersData.total_teachers || 0;
    document.getElementById("classes-count").textContent =
        classesData.total_classes || 0;

    const percentage =
        paymentData.percentage_paid !== undefined
            ? Math.round(paymentData.percentage_paid)
            : 0;

    document.getElementById("payments-count").textContent = `${percentage}%`;
}

function renderLevels() {
    const container = document.getElementById("levels-list");
    container.replaceChildren();

    if (levelsData.length === 0 && !levelsEditMode) {
        const empty = document.createElement("div");
        empty.className =
            "p-5 bg-gray-900 border border-gray-700 rounded-xl text-lg text-gray-400";
        empty.textContent = "Aucun niveau trouvé";
        container.appendChild(empty);
    }

    levelsData.forEach((level) => {
        const div = document.createElement("div");
        div.className =
            "p-4 bg-gray-900 border border-gray-700 rounded-xl flex items-center justify-between";

        const name = document.createElement("span");
        name.className = "text-white text-sm font-bold uppercase";
        name.textContent = level.name;
        div.appendChild(name);

        if (levelsEditMode) {
            const btn = document.createElement("button");
            btn.className =
                "text-red-400 hover:text-red-300 text-xs font-black uppercase tracking-widest";
            btn.textContent = "Supprimer";
            btn.addEventListener("click", () =>
                deleteItem("levels", level.id, "levels"),
            );
            div.appendChild(btn);
        }

        container.appendChild(div);
    });

    if (levelsEditMode) {
        const addRow = document.createElement("div");
        addRow.className = "flex gap-2 mt-1";

        const input = document.createElement("input");
        input.type = "text";
        input.placeholder = "Nouveau niveau...";
        input.className =
            "flex-1 bg-gray-900 border border-gray-700 px-3 py-2 text-sm text-white";

        const addBtn = document.createElement("button");
        addBtn.className =
            "px-4 py-2 bg-amber-500 text-black text-xs font-bold";
        addBtn.textContent = "+ Ajouter";
        addBtn.onclick = () => addItem("levels", input, "levels");

        addRow.appendChild(input);
        addRow.appendChild(addBtn);
        container.appendChild(addRow);
    }
}

function renderSubjects() {
    const container = document.getElementById("subjects-list");
    container.replaceChildren();

    subjectsData.forEach((subject) => {
        const div = document.createElement("div");
        div.className =
            "p-4 bg-gray-900 border border-gray-700 rounded-xl flex justify-between";

        const name = document.createElement("span");
        name.textContent = subject.name;

        div.appendChild(name);

        if (subjectsEditMode) {
            const btn = document.createElement("button");
            btn.textContent = "Supprimer";
            btn.onclick = () => deleteItem("subjects", subject.id, "subjects");
            div.appendChild(btn);
        }

        container.appendChild(div);
    });
}

async function addItem(endpoint, input, type) {
    const name = input.value.trim();
    if (!name) return;

    try {
        const response = await fetch(`/api/v1/${endpoint}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: `Bearer ${getToken()}`,
            },
            body: JSON.stringify({ name }),
        });

        if (!response.ok) throw new Error();

        const result = await response.json();
        const newItem = result.data || result;

        if (type === "levels") {
            levelsData.push(newItem);
            renderLevels();
        } else {
            subjectsData.push(newItem);
            renderSubjects();
        }
    } catch {
        showErrorMessage("Erreur lors de l'ajout.");
    }
}

async function deleteItem(endpoint, id, type) {
    try {
        const response = await fetch(`/api/v1/${endpoint}/${id}`, {
            method: "DELETE",
            headers: {
                Accept: "application/json",
                Authorization: `Bearer ${getToken()}`,
            },
        });

        if (!response.ok) throw new Error();

        if (type === "levels") {
            levelsData = levelsData.filter((i) => i.id !== id);
            renderLevels();
        } else {
            subjectsData = subjectsData.filter((i) => i.id !== id);
            renderSubjects();
        }
    } catch {
        showErrorMessage("Erreur lors de la suppression.");
    }
}

function setupManageButtons() {
    const buttons = document.querySelectorAll(".manage-btn");

    buttons[0]?.addEventListener("click", () => {
        levelsEditMode = !levelsEditMode;
        renderLevels();
    });

    buttons[1]?.addEventListener("click", () => {
        subjectsEditMode = !subjectsEditMode;
        renderSubjects();
    });
}

function updateAbsencesList(absences) {
    const container = document.getElementById("absences-list");
    container.replaceChildren();

    const list = Array.isArray(absences) ? absences : absences.data || [];

    list.forEach((abs) => {
        const div = document.createElement("div");
        div.textContent =
            abs.inscription?.student?.user?.prenom || "Élève inconnu";
        container.appendChild(div);
    });
}

function showErrorMessage(msg = "Erreur") {
    console.error(msg);
}
