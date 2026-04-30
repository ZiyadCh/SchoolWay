document.addEventListener("DOMContentLoaded", function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const token = localStorage.getItem("token");
    const inscriptions = user?.student?.inscriptions || [];
    const activeInscription = inscriptions.find(
        (ins) => ins.statut === "active",
    );
    const inscriptionId = activeInscription
        ? activeInscription.id
        : inscriptions[0]?.id;
    const container = document.getElementById("paiements-container");

    async function fetchPaiements() {
        if (!container) return;

        try {
            const response = await fetch(
                `/api/v1/paiments?inscription_id=${inscriptionId}`,
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: "application/json",
                    },
                },
            );

            if (!response.ok) throw new Error("Erreur");

            const result = await response.json();
            renderUI(result.data || []);
        } catch (error) {
            console.error("Erreur:", error);
            displayMessage("Erreur de chargement", "text-red-500");
        }
    }

    function displayMessage(message, textClass) {
        container.replaceChildren();
        const tr = document.createElement("tr");
        const td = document.createElement("td");
        td.setAttribute("colspan", "2");
        td.className = `p-10 text-center uppercase font-black text-xs tracking-widest ${textClass}`;
        td.textContent = message;
        tr.appendChild(td);
        container.appendChild(tr);
    }

    function renderUI(data) {
        container.replaceChildren();

        if (data.length === 0) {
            displayMessage("Aucun historique trouvé", "text-gray-500");
            return;
        }

        data.forEach((paiement) => {
            const tr = document.createElement("tr");
            tr.className = "hover:bg-gray-800/30 transition-colors";

            const tdMonth = document.createElement("td");
            tdMonth.className = "p-5 font-bold text-gray-200 uppercase text-lg";

            const dateObj = new Date(paiement.mois);
            tdMonth.textContent = isNaN(dateObj.getTime())
                ? paiement.mois
                : new Intl.DateTimeFormat("fr-FR", {
                      month: "long",
                      year: "numeric",
                  }).format(dateObj);

            const tdStatus = document.createElement("td");
            tdStatus.className = "p-5 text-right";

            const isPaid =
                paiement.etatPaiement === true || paiement.etatPaiement === 1;
            const span = document.createElement("span");
            span.className = `px-3 py-2 text-[13px] font-black uppercase rounded-full border ${
                isPaid
                    ? "bg-emerald-400/10 text-emerald-400 border-emerald-400/20"
                    : "bg-red-400/10 text-red-400 border-red-400/20"
            }`;
            span.textContent = isPaid ? "Payé" : "En attente";

            tdStatus.appendChild(span);
            tr.append(tdMonth, tdStatus);
            container.appendChild(tr);
        });
    }

    fetchPaiements();
});
