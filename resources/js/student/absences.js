document.addEventListener("DOMContentLoaded", function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const inscriptionId = user?.student?.inscriptions?.[0]?.id;

    if (!inscriptionId) {
        displayTableMessage("Aucune inscription trouvée", "text-red-500");
        return;
    }

    const apiUrl = `/api/v1/absences?inscription_id=${inscriptionId}`;
    const tableBody = document.getElementById("absences-table-body");
    const totalEl = document.getElementById("total-absences");
    const justifiedEl = document.getElementById("justified-count");
    const unjustifiedEl = document.getElementById("unjustified-count");

    async function fetchAbsences() {
        try {
            const token = localStorage.getItem("token");
            const response = await fetch(apiUrl, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            });
            if (!response.ok) throw new Error("Erreur réseau");
            const result = await response.json();
            const absencesArray = result.data || [];
            renderUI(absencesArray);
        } catch (error) {
            console.error("Erreur:", error);
            displayTableMessage(
                "Erreur de chargement des données",
                "text-red-500",
            );
        }
    }

    function displayTableMessage(message, textClass) {
        tableBody.replaceChildren();
        const tr = document.createElement("tr");
        const td = document.createElement("td");
        td.setAttribute("colspan", "2");
        td.className = `p-10 text-center uppercase font-black text-xs tracking-widest ${textClass}`;
        td.textContent = message;
        tr.appendChild(td);
        tableBody.appendChild(tr);
    }

    function renderUI(data) {
        const total = data.length;
        const justified = data.filter(
            (a) => a.justifié === true || a.justifié === 1,
        ).length;
        const unjustified = total - justified;

        totalEl.textContent = total.toString().padStart(2, "0");
        justifiedEl.textContent = justified.toString().padStart(2, "0");
        unjustifiedEl.textContent = unjustified.toString().padStart(2, "0");

        tableBody.replaceChildren();

        if (total === 0) {
            displayTableMessage("Aucune absence enregistrée", "text-gray-500");
            return;
        }

        data.forEach((absence) => {
            const tr = document.createElement("tr");
            tr.className = "hover:bg-gray-800 transition-colors group";

            const tdDate = document.createElement("td");
            tdDate.className = "p-6 text-gray-200 text-lg font-bold uppercase";
            tdDate.textContent = formatDate(absence.date);

            const tdStatus = document.createElement("td");
            tdStatus.className = "p-6 text-right whitespace-nowrap";

            const span = document.createElement("span");
            const isJustified =
                absence.justifié === true || absence.justifié === 1;
            span.className = `px-4 py-1 text-xs font-black uppercase rounded-full shadow-lg ${
                isJustified
                    ? "bg-emerald-500 text-black"
                    : "bg-red-600 text-white"
            }`;
            span.textContent = isJustified ? "Justifiée" : "Non Justifiée";

            tdStatus.appendChild(span);
            tr.append(tdDate, tdStatus);
            tableBody.appendChild(tr);
        });
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat("fr-FR", {
            day: "2-digit",
            month: "long",
            year: "numeric",
        }).format(date);
    }

    fetchAbsences();
});
