import getToken from "../auth/token.js";
let currentYear = null;

document.addEventListener("DOMContentLoaded", () => {
    loadCurrentYear();
    setupCreateYear();
    setupEndYear();
});

async function loadCurrentYear() {
    try {
        const response = await fetch("/api/v1/years", {
            headers: {
                Authorization: `Bearer ${getToken()}`,
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
                            Authorization: `Bearer ${getToken()}`,
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
                currentYear = null;
                await loadCurrentYear();
            } catch (e) {
                console.error(e);
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
                        Authorization: `Bearer ${getToken()}`,
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
