const token = localStorage.getItem("token");
let currentYear = null;
let allStudents = [];
let excludedIds = new Set();

document.addEventListener("DOMContentLoaded", () => {
    loadCurrentYear();
    loadAllStudents();
    loadYearsForRollover();
    setupCreateYear();
    setupEndYear();
    setupRollover();
    setupSearch();
});

async function loadCurrentYear() {
    try {
        const response = await fetch("/api/v1/years", {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });
        const result = await response.json();
        const years = result.data || [];
        currentYear = years.find((y) => y.current);

        const info = document.getElementById("current-year-info");
        const btn = document.getElementById("btn-end-year");
        info.classList.remove("animate-pulse");

        if (!currentYear) {
            info.textContent = "Aucune année active.";
            return;
        }

        const wrapper = document.createElement("div");
        wrapper.className = "space-y-2";

        const title = document.createElement("p");
        title.className = "text-2xl font-black text-white uppercase";
        title.textContent = currentYear.title;

        const dates = document.createElement("p");
        dates.className =
            "text-xs text-gray-500 font-bold uppercase tracking-widest";
        dates.textContent = `${formatDate(currentYear.beginning_date)} → ${formatDate(currentYear.end_date)}`;

        wrapper.appendChild(title);
        wrapper.appendChild(dates);
        info.replaceChildren(wrapper);
        btn.classList.remove("hidden");
    } catch (e) {
        console.error(e);
    }
}

async function loadYearsForRollover() {
    try {
        const response = await fetch("/api/v1/years", {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });
        const result = await response.json();
        const years = result.data || [];
        const select = document.getElementById("rollover-year-select");

        years
            .filter((y) => !y.current)
            .forEach((year) => {
                const option = document.createElement("option");
                option.value = year.id;
                option.textContent = year.title;
                select.appendChild(option);
            });
    } catch (e) {
        console.error(e);
    }
}

async function loadAllStudents() {
    try {
        const response = await fetch("/api/v1/students?all=1", {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });
        const result = await response.json();
        allStudents = result.data || [];
        renderStudentList(allStudents);
    } catch (e) {
        console.error(e);
    }
}

function renderStudentList(students) {
    const container = document.getElementById("students-rollover-list");
    container.replaceChildren();

    if (students.length === 0) {
        const msg = document.createElement("p");
        msg.className =
            "text-center text-gray-500 text-xs uppercase font-black p-4";
        msg.textContent = "Aucun étudiant trouvé";
        container.appendChild(msg);
        return;
    }

    students.forEach((student) => {
        const user = student.user || {};
        const fullName = `${user.prenom || ""} ${user.nom || ""}`
            .trim()
            .toUpperCase();
        const photoUrl = user.photo
            ? `/storage/${user.photo}`
            : `/images/default.jpeg`;

        const label = document.createElement("label");
        label.className =
            "flex items-center gap-3 p-3 rounded-lg hover:bg-gray-800 cursor-pointer transition-colors";

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.value = student.id;
        checkbox.checked = !excludedIds.has(student.id);
        checkbox.className = "w-4 h-4 accent-amber-500";
        checkbox.addEventListener("change", () => {
            if (checkbox.checked) {
                excludedIds.delete(student.id);
            } else {
                excludedIds.add(student.id);
            }
        });

        const img = document.createElement("img");
        img.src = photoUrl;
        img.className =
            "w-8 h-8 rounded-lg object-cover border border-gray-700";

        const name = document.createElement("span");
        name.className = "text-sm font-bold text-gray-200 uppercase flex-1";
        name.textContent = fullName;

        label.appendChild(checkbox);
        label.appendChild(img);
        label.appendChild(name);
        container.appendChild(label);
    });
}

function setupSearch() {
    document.getElementById("student-search").addEventListener("input", (e) => {
        const q = e.target.value.toLowerCase();
        const filtered = allStudents.filter((s) => {
            const name =
                `${s.user?.prenom || ""} ${s.user?.nom || ""}`.toLowerCase();
            return name.includes(q);
        });
        renderStudentList(filtered);
    });

    document.getElementById("btn-check-all").addEventListener("click", () => {
        excludedIds.clear();
        renderStudentList(allStudents);
    });

    document.getElementById("btn-uncheck-all").addEventListener("click", () => {
        allStudents.forEach((s) => excludedIds.add(s.id));
        renderStudentList(allStudents);
    });
}

function setupEndYear() {
    const modal = document.getElementById("end-year-modal");

    document.getElementById("btn-end-year").addEventListener("click", () => {
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    });

    document.getElementById("cancel-end-year").addEventListener("click", () => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    });

    document
        .getElementById("confirm-end-year")
        .addEventListener("click", async () => {
            if (!currentYear) return;

            try {
                const response = await fetch(
                    `/api/v1/years/${currentYear.id}/end`,
                    {
                        method: "POST",
                        headers: {
                            Authorization: `Bearer ${token}`,
                            Accept: "application/json",
                        },
                    },
                );

                const result = await response.json();

                if (!response.ok) {
                    showMessage(
                        "create-year-message",
                        result.message || "Erreur.",
                        "text-red-400",
                    );
                    return;
                }

                modal.classList.add("hidden");
                modal.classList.remove("flex");
                await loadCurrentYear();
                await loadYearsForRollover();
            } catch (e) {
                console.error(e);
            }
        });
}

function setupRollover() {
    document
        .getElementById("btn-rollover")
        .addEventListener("click", async () => {
            const yearId = document.getElementById(
                "rollover-year-select",
            ).value;

            if (!yearId) {
                showMessage(
                    "rollover-message",
                    "Veuillez sélectionner une année cible.",
                    "text-red-400",
                );
                return;
            }

            if (!currentYear) {
                showMessage(
                    "rollover-message",
                    "Aucune année active trouvée.",
                    "text-red-400",
                );
                return;
            }

            try {
                const response = await fetch(
                    `/api/v1/years/${currentYear.id}/rollover`,
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: `Bearer ${token}`,
                            Accept: "application/json",
                        },
                        body: JSON.stringify({
                            target_year_id: yearId,
                            exclude: Array.from(excludedIds),
                        }),
                    },
                );

                const result = await response.json();

                if (!response.ok) {
                    showMessage(
                        "rollover-message",
                        result.message || "Erreur.",
                        "text-red-400",
                    );
                    return;
                }

                showMessage(
                    "rollover-message",
                    result.message,
                    "text-emerald-400",
                );
            } catch (e) {
                showMessage(
                    "rollover-message",
                    "Erreur de connexion.",
                    "text-red-400",
                );
            }
        });
}

function setupCreateYear() {
    document
        .getElementById("btn-create-year")
        .addEventListener("click", async () => {
            const title = document
                .getElementById("new-year-title")
                .value.trim();
            const beginning_date =
                document.getElementById("new-year-start").value;
            const end_date = document.getElementById("new-year-end").value;

            if (!title || !beginning_date || !end_date) {
                showMessage(
                    "create-year-message",
                    "Veuillez remplir tous les champs.",
                    "text-red-400",
                );
                return;
            }

            try {
                const response = await fetch("/api/v1/years", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                    body: JSON.stringify({ title, beginning_date, end_date }),
                });

                const result = await response.json();

                if (!response.ok) {
                    showMessage(
                        "create-year-message",
                        result.message || "Erreur.",
                        "text-red-400",
                    );
                    return;
                }

                showMessage(
                    "create-year-message",
                    "Année créée avec succès.",
                    "text-emerald-400",
                );
                document.getElementById("new-year-title").value = "";
                document.getElementById("new-year-start").value = "";
                document.getElementById("new-year-end").value = "";
                await loadYearsForRollover();
            } catch (e) {
                showMessage(
                    "create-year-message",
                    "Erreur de connexion.",
                    "text-red-400",
                );
            }
        });
}

function showMessage(elId, text, colorClass) {
    const el = document.getElementById(elId);
    el.textContent = text;
    el.className = `text-[11px] font-bold ${colorClass}`;
    el.classList.remove("hidden");
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString("fr-FR", {
        day: "2-digit",
        month: "long",
        year: "numeric",
    });
}
