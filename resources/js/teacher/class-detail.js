const token = localStorage.getItem("token");
const classId = window.location.pathname.split("/").pop();
let allInscriptions = [];
let selectedAbsenceIds = new Set();

document.addEventListener("DOMContentLoaded", () => {
    fetchClassDetail();
    setupModals();
    setupSubmitHandlers();
});

async function fetchClassDetail() {
    try {
        const response = await fetch(`/api/v1/school_classes/${classId}`, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });

        if (!response.ok) throw new Error("Erreur");

        const result = await response.json();
        const cls = result.data || result;

        document.getElementById("class-name").textContent = cls.name;
        allInscriptions = cls.inscriptions || [];
        renderStudents(allInscriptions);
    } catch (error) {
        console.error(error);
        document.getElementById("students-body").innerHTML = `
            <tr><td colspan="2" class="p-10 text-center text-red-500 uppercase font-black text-xs tracking-widest">Erreur de chargement</td></tr>
        `;
    }
}

function renderStudents(inscriptions) {
    const body = document.getElementById("students-body");

    while (body.firstChild) {
        body.removeChild(body.firstChild);
    }

    if (inscriptions.length === 0) {
        const tr = document.createElement("tr");
        const td = document.createElement("td");
        td.setAttribute("colspan", "2");
        td.className =
            "p-10 text-center text-gray-500 uppercase font-black text-xs tracking-widest";
        td.textContent = "Aucun élève inscrit";
        tr.appendChild(td);
        body.appendChild(tr);
        return;
    }

    inscriptions.forEach((inscription) => {
        const user = inscription.student?.user;
        const fullName = user ? `${user.prenom} ${user.nom}` : "---";
        const email = user?.email || "---";
        const photoUrl = user?.photo
            ? `/storage/${user.photo}`
            : `/images/default.jpeg`;

        const tr = document.createElement("tr");
        tr.className =
            "hover:bg-gray-800/30 transition-colors border-b border-gray-800/50 last:border-0";

        const tdName = document.createElement("td");
        tdName.className = "p-5";

        const flexDiv = document.createElement("div");
        flexDiv.className = "flex items-center gap-4";

        const img = document.createElement("img");
        img.src = photoUrl;
        img.className =
            "w-10 h-10 rounded-lg object-cover border border-gray-700 shadow-sm";
        img.alt = "Avatar";

        const nameLink = document.createElement("a");
        nameLink.href = `/students/${inscription.id}`;
        nameLink.className =
            "font-bold text-gray-200 uppercase text-sm hover:text-amber-500 transition-colors tracking-tight";
        nameLink.textContent = fullName;

        flexDiv.appendChild(img);
        flexDiv.appendChild(nameLink);
        tdName.appendChild(flexDiv);

        const tdEmail = document.createElement("td");
        tdEmail.className = "p-5 text-sm text-gray-500 font-medium";
        tdEmail.textContent = email;

        tr.appendChild(tdName);
        tr.appendChild(tdEmail);

        body.appendChild(tr);
    });
}

function openAbsenceModal() {
    selectedAbsenceIds.clear();
    document.getElementById("absence-date").value = new Date()
        .toISOString()
        .split("T")[0];
    document.getElementById("absence-justified").checked = false;
    renderAbsenceStudentList();
    showModal("absence-modal");
}

function renderAbsenceStudentList() {
    const container = document.getElementById("absence-student-list");
    container.innerHTML = "";

    allInscriptions.forEach((inscription) => {
        const user = inscription.student?.user;
        const fullName = user ? `${user.prenom} ${user.nom}` : "---";
        const photoUrl = user?.photo
            ? `/storage/${user.photo}`
            : `/images/default.jpeg`;

        const label = document.createElement("label");
        label.className =
            "flex items-center gap-3 p-3 rounded-lg hover:bg-gray-800 cursor-pointer transition-colors";

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.value = inscription.id;
        checkbox.className = "w-4 h-4 accent-amber-500";
        checkbox.addEventListener("change", () => {
            if (checkbox.checked) {
                selectedAbsenceIds.add(inscription.id);
            } else {
                selectedAbsenceIds.delete(inscription.id);
            }
        });

        const img = document.createElement("img");
        img.src = photoUrl;
        img.className =
            "w-7 h-7 rounded-lg object-cover border border-gray-700";

        const name = document.createElement("span");
        name.className = "text-sm font-bold text-gray-200 uppercase";
        name.textContent = fullName;

        label.appendChild(checkbox);
        label.appendChild(img);
        label.appendChild(name);
        container.appendChild(label);
    });
}

function setupModals() {
    document
        .getElementById("btn-add-devoir")
        .addEventListener("click", () => showModal("devoir-modal"));
    document
        .getElementById("btn-add-exam")
        .addEventListener("click", () => showModal("exam-modal"));
    document
        .getElementById("btn-add-absence")
        .addEventListener("click", () => openAbsenceModal());

    document.querySelectorAll(".close-modal").forEach((btn) => {
        btn.addEventListener("click", () => {
            hideModal("devoir-modal");
            hideModal("exam-modal");
            hideModal("absence-modal");
        });
    });

    ["devoir-modal", "exam-modal", "absence-modal"].forEach((id) => {
        document.getElementById(id).addEventListener("click", (e) => {
            if (e.target === document.getElementById(id)) hideModal(id);
        });
    });
}

function showModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove("hidden");
    modal.classList.add("flex");
}

function hideModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add("hidden");
    modal.classList.remove("flex");
}

function showMessage(elId, text, colorClass) {
    const el = document.getElementById(elId);
    el.textContent = text;
    el.className = `text-[11px] font-bold text-center ${colorClass}`;
    el.classList.remove("hidden");
}

function setupSubmitHandlers() {
    document
        .getElementById("submit-devoir")
        .addEventListener("click", async () => {
            const title = document.getElementById("devoir-title").value.trim();
            const deadline = document.getElementById("devoir-deadline").value;
            const contenu = document
                .getElementById("devoir-contenu")
                .value.trim();

            if (!title || !deadline) {
                showMessage(
                    "devoir-message",
                    "Veuillez remplir les champs obligatoires.",
                    "text-red-400",
                );
                return;
            }

            try {
                const response = await fetch("/api/v1/devoirs", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({
                        title,
                        deadline,
                        contenu,
                        school_class_id: classId,
                    }),
                });

                const result = await response.json();

                if (!response.ok) {
                    showMessage(
                        "devoir-message",
                        result.message || "Erreur.",
                        "text-red-400",
                    );
                    return;
                }

                showMessage(
                    "devoir-message",
                    "Devoir créé avec succès.",
                    "text-emerald-400",
                );
                document.getElementById("devoir-title").value = "";
                document.getElementById("devoir-deadline").value = "";
                document.getElementById("devoir-contenu").value = "";
                setTimeout(() => hideModal("devoir-modal"), 1500);
            } catch (e) {
                showMessage(
                    "devoir-message",
                    "Erreur de connexion.",
                    "text-red-400",
                );
            }
        });

    document
        .getElementById("submit-exam")
        .addEventListener("click", async () => {
            const title = document.getElementById("exam-title").value.trim();
            const date = document.getElementById("exam-date").value;

            if (!title || !date) {
                showMessage(
                    "exam-message",
                    "Veuillez remplir les champs obligatoires.",
                    "text-red-400",
                );
                return;
            }

            try {
                const notes = allInscriptions.map((ins) => ({
                    inscription_id: ins.id,
                    valeur: null,
                }));

                const response = await fetch("/api/v1/exams", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({
                        title,
                        date,
                        school_class_id: classId,
                        notes,
                    }),
                });

                const result = await response.json();

                if (!response.ok) {
                    showMessage(
                        "exam-message",
                        result.message || "Erreur.",
                        "text-red-400",
                    );
                    return;
                }

                showMessage(
                    "exam-message",
                    "Examen créé avec succès.",
                    "text-emerald-400",
                );
                document.getElementById("exam-title").value = "";
                document.getElementById("exam-date").value = "";
                setTimeout(() => hideModal("exam-modal"), 1500);
            } catch (e) {
                showMessage(
                    "exam-message",
                    "Erreur de connexion.",
                    "text-red-400",
                );
            }
        });

    document
        .getElementById("submit-absence")
        .addEventListener("click", async () => {
            const date = document.getElementById("absence-date").value;
            const justified =
                document.getElementById("absence-justified").checked;

            if (!date) {
                showMessage(
                    "absence-message",
                    "Veuillez sélectionner une date.",
                    "text-red-400",
                );
                return;
            }

            if (selectedAbsenceIds.size === 0) {
                showMessage(
                    "absence-message",
                    "Veuillez sélectionner au moins un élève.",
                    "text-red-400",
                );
                return;
            }

            try {
                const requests = Array.from(selectedAbsenceIds).map(
                    (inscriptionId) =>
                        fetch("/api/v1/absences", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                Authorization: `Bearer ${token}`,
                                Accept: "application/json",
                            },
                            body: JSON.stringify({
                                inscription_id: inscriptionId,
                                date,
                                justifié: justified,
                            }),
                        }),
                );

                await Promise.all(requests);

                showMessage(
                    "absence-message",
                    `${selectedAbsenceIds.size} absence(s) enregistrée(s).`,
                    "text-emerald-400",
                );
                setTimeout(() => hideModal("absence-modal"), 1500);
            } catch (e) {
                showMessage(
                    "absence-message",
                    "Erreur de connexion.",
                    "text-red-400",
                );
            }
        });
}
