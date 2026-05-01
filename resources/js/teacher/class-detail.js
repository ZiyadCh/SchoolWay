const token = localStorage.getItem("token");
const classId = window.location.pathname.split("/").pop();
let selectedInscriptionId = null;
let selectedStudentName = null;

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
        renderStudents(cls.inscriptions || []);
    } catch (error) {
        console.error(error);
        document.getElementById("students-body").innerHTML = `
            <tr><td colspan="3" class="p-10 text-center text-red-500 uppercase font-black text-xs tracking-widest">Erreur de chargement</td></tr>
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
        td.setAttribute("colspan", "3");
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
        tr.className = "hover:bg-gray-800/30 transition-colors group";

        const tdName = document.createElement("td");
        tdName.className = "p-5";

        const flexDiv = document.createElement("div");
        flexDiv.className = "flex items-center gap-3";

        const img = document.createElement("img");
        img.src = photoUrl;
        img.className =
            "w-8 h-8 rounded-lg object-cover border border-gray-700";
        img.alt = "Avatar";

        const nameSpan = document.createElement("span");
        nameSpan.className = "font-bold text-gray-200 uppercase text-sm";
        nameSpan.textContent = fullName;

        flexDiv.appendChild(img);
        flexDiv.appendChild(nameSpan);
        tdName.appendChild(flexDiv);

        const tdEmail = document.createElement("td");
        tdEmail.className = "p-5 text-sm text-gray-500";
        tdEmail.textContent = email;

        const tdAction = document.createElement("td");
        tdAction.className = "p-5 text-right";

        const btn = document.createElement("button");
        btn.className =
            "px-3 py-1.5 text-[9px] font-black uppercase tracking-widest rounded-lg border border-gray-700 text-gray-400 hover:border-red-500 hover:text-red-400 transition-colors";
        btn.textContent = "+ Absence";

        btn.addEventListener("click", () =>
            openAbsenceModal(inscription.id, fullName),
        );

        tdAction.appendChild(btn);

        tr.appendChild(tdName);
        tr.appendChild(tdEmail);
        tr.appendChild(tdAction);

        body.appendChild(tr);
    });
}

function openAbsenceModal(inscriptionId, studentName) {
    selectedInscriptionId = inscriptionId;
    document.getElementById("absence-student-name").textContent = studentName;
    document.getElementById("absence-date").value = new Date()
        .toISOString()
        .split("T")[0];
    showModal("absence-modal");
}

function setupModals() {
    document
        .getElementById("btn-add-devoir")
        .addEventListener("click", () => showModal("devoir-modal"));
    document
        .getElementById("btn-add-exam")
        .addEventListener("click", () => showModal("exam-modal"));

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
                const inscriptionsRes = await fetch(
                    `/api/v1/school_classes/${classId}`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            Accept: "application/json",
                        },
                    },
                );
                const inscriptionsResult = await inscriptionsRes.json();
                const inscriptions =
                    (inscriptionsResult.data || inscriptionsResult)
                        .inscriptions || [];
                const notes = inscriptions.map((ins) => ({
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

            if (!date) {
                showMessage(
                    "absence-message",
                    "Veuillez sélectionner une date.",
                    "text-red-400",
                );
                return;
            }

            try {
                const response = await fetch("/api/v1/absences", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({
                        inscription_id: selectedInscriptionId,
                        date,
                    }),
                });

                const result = await response.json();

                if (!response.ok) {
                    showMessage(
                        "absence-message",
                        result.message || "Erreur.",
                        "text-red-400",
                    );
                    return;
                }

                showMessage(
                    "absence-message",
                    "Absence enregistrée.",
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
