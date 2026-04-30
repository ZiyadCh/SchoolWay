document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const studentId = params.get("inscription_id") || 1;
    const token = localStorage.getItem("token");
    const container = document.getElementById("paiements-container");

    async function fetchPaiements() {
        if (!container) return;

        try {
            const response = await fetch(
                `/api/v1/paiments/paiment-stats?student_id=${studentId}`,
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                },
            );

            if (!response.ok)
                throw new Error("Erreur lors de la récupération des paiements");

            const result = await response.json();
            const paiements = result.data || result;

            renderUI(paiements);
        } catch (error) {
            console.error("Erreur:", error);
            renderMessage(
                "Impossible de charger les paiements",
                "text-red-500",
            );
        }
    }

    function renderMessage(message, textClass) {
        container.replaceChildren();
        const msgDiv = document.createElement("div");
        msgDiv.className = `col-span-full text-center font-black uppercase text-xs p-10 tracking-widest ${textClass}`;
        msgDiv.textContent = message;
        container.appendChild(msgDiv);
    }

    function renderUI(data) {
        container.replaceChildren();

        if (data.length === 0) {
            renderMessage(
                "Aucun historique de paiement trouvé",
                "text-gray-500 border border-dashed border-gray-800 rounded-2xl",
            );
            return;
        }

        data.forEach((paiement) => {
            const status = (
                paiement.status ||
                paiement.statut ||
                "pending"
            ).toLowerCase();
            const isPaid =
                status === "paid" ||
                status === "payé" ||
                status === "completed";

            // --- Card Container ---
            const card = document.createElement("div");
            card.className =
                "bg-gray-900 border border-gray-800 p-6 rounded-2xl hover:border-gray-700 transition-all relative overflow-hidden flex flex-col";

            // --- Status Accent (Top Bar) ---
            const accent = document.createElement("div");
            accent.className = `absolute left-0 right-0 top-0 h-1 ${isPaid ? "bg-emerald-500" : "bg-rose-500"}`;
            card.appendChild(accent);

            // --- Month & Year ---
            const dateLabel = document.createElement("p");
            dateLabel.className =
                "text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1";
            dateLabel.textContent = paiement.period || "Mensualité";
            card.appendChild(dateLabel);

            // --- Amount ---
            const amount = document.createElement("h3");
            amount.className = "text-2xl font-black text-white mb-4";
            // Formatage monétaire (ex: 500 DH ou 500 €)
            amount.textContent = new Intl.NumberFormat("fr-FR", {
                style: "currency",
                currency: "EUR",
            }).format(paiement.amount || 0);
            card.appendChild(amount);

            // --- Status Badge ---
            const statusWrapper = document.createElement("div");
            statusWrapper.className =
                "flex items-center justify-between mt-auto pt-4 border-t border-gray-800/50";

            const badge = document.createElement("span");
            badge.className = `px-3 py-1 text-[9px] font-black uppercase rounded-md border ${
                isPaid
                    ? "bg-emerald-500/10 text-emerald-500 border-emerald-500/30"
                    : "bg-rose-500/10 text-rose-500 border-rose-500/30"
            }`;
            badge.textContent = isPaid ? "Réglé" : "En attente";

            statusWrapper.appendChild(badge);

            // --- Reference / Date ---
            const refText = document.createElement("span");
            refText.className = "text-[10px] font-mono text-gray-600";
            refText.textContent = paiement.date_paiement
                ? `Le ${formatShortDate(paiement.date_paiement)}`
                : "Réf: " + (paiement.id || "---");

            statusWrapper.appendChild(refText);
            card.appendChild(statusWrapper);

            container.appendChild(card);
        });
    }

    function formatShortDate(dateString) {
        return new Intl.DateTimeFormat("fr-FR", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
        }).format(new Date(dateString));
    }

    fetchPaiements();
});
