document.addEventListener("DOMContentLoaded", function () {
    const user = JSON.parse(localStorage.getItem("user"));
    const inscriptionId = user?.student?.inscriptions?.[0]?.id;
    import getToken from "../auth/token.js";
    const container = document.getElementById("devoirs-container");

    async function fetchAllDevoirs() {
        if (!container) return;

        try {
            const classesRes = await fetch(
                `/api/v1/school_classes?inscription_id=${inscriptionId}`,
                {
                    headers: {
                        Authorization: `Bearer ${getToken()}`,
                        Accept: "application/json",
                    },
                },
            );

            if (!classesRes.ok) throw new Error("Erreur classes");

            const classesResult = await classesRes.json();
            const classes = classesResult.data || [];

            if (classes.length === 0) {
                renderUI([]);
                return;
            }

            const requests = classes.map((classe) =>
                fetch(`/api/v1/devoirs?school_class_id=${classe.id}`, {
                    headers: {
                        Authorization: `Bearer ${getToken()}`,
                        Accept: "application/json",
                    },
                }).then((res) => (res.ok ? res.json() : { data: [] })),
            );

            const results = await Promise.all(requests);
            const allDevoirs = results.flatMap((res) => res.data || res);

            allDevoirs.sort(
                (a, b) => new Date(a.deadline) - new Date(b.deadline),
            );

            renderUI(allDevoirs);
        } catch (error) {
            console.error("Erreur:", error);
            renderMessage("Erreur de chargement des données", "text-red-500");
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
                "Aucun devoir pour le moment",
                "text-gray-500 border border-dashed border-gray-800 rounded-2xl",
            );
            return;
        }

        data.forEach((devoir) => {
            const isDone = devoir.statut === "completed";

            const card = document.createElement("div");
            card.className =
                "bg-gray-900 border border-gray-800 p-6 rounded-2xl hover:border-gray-600 transition-all group relative overflow-hidden flex flex-col justify-between";

            const accent = document.createElement("div");
            accent.className = `absolute left-0 top-0 bottom-0 w-1 ${isDone ? "bg-emerald-500" : "bg-amber-500"}`;
            card.appendChild(accent);

            const topWrapper = document.createElement("div");

            const headerRow = document.createElement("div");
            headerRow.className = "flex justify-between items-start mb-3 pl-2";

            const subjectLabel = document.createElement("p");
            subjectLabel.className =
                "text-[10px] font-black text-amber-500 uppercase tracking-widest";
            subjectLabel.textContent = devoir.school_class?.name || "Cours";
            headerRow.appendChild(subjectLabel);
            topWrapper.appendChild(headerRow);

            const title = document.createElement("h3");
            title.className =
                "pl-2 text-base font-bold text-white uppercase leading-tight group-hover:text-amber-400 transition-colors mb-2";
            title.textContent = devoir.title;
            topWrapper.appendChild(title);

            const description = document.createElement("p");
            description.className =
                "pl-2 text-sm text-gray-500 line-clamp-2 mb-4 italic";
            description.textContent =
                devoir.contenu || "Aucune instruction supplémentaire.";
            topWrapper.appendChild(description);

            card.appendChild(topWrapper);

            const footer = document.createElement("div");
            footer.className =
                "flex items-center justify-between pl-2 mt-auto pt-4 border-t border-gray-800/50";

            const dateWrapper = document.createElement("div");
            dateWrapper.className = "flex items-center gap-2 text-gray-400";

            const svgNS = "http://www.w3.org/2000/svg";
            const svg = document.createElementNS(svgNS, "svg");
            svg.setAttribute("viewBox", "0 0 24 24");
            svg.setAttribute("fill", "none");
            svg.setAttribute("stroke", "currentColor");
            svg.classList.add("h-3.5", "w-3.5");

            const path = document.createElementNS(svgNS, "path");
            path.setAttribute(
                "d",
                "M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z",
            );
            path.setAttribute("stroke-linecap", "round");
            path.setAttribute("stroke-linejoin", "round");
            path.setAttribute("stroke-width", "2");

            svg.appendChild(path);
            dateWrapper.appendChild(svg);

            const dateText = document.createElement("span");
            dateText.className = "text-[11px] font-bold font-mono";
            dateText.textContent = formatDeadline(devoir.deadline);

            dateWrapper.appendChild(dateText);
            footer.appendChild(dateWrapper);
            card.appendChild(footer);

            container.appendChild(card);
        });
    }

    function formatDeadline(dateString) {
        if (!dateString) return "N/A";
        const date = new Date(dateString);
        const now = new Date();
        now.setHours(0, 0, 0, 0);
        const diffDays = Math.ceil((date - now) / (1000 * 60 * 60 * 24));

        if (diffDays === 0) return "Aujourd'hui";
        if (diffDays === 1) return "Demain";
        if (diffDays < 0) return "En retard";

        return new Intl.DateTimeFormat("fr-FR", {
            day: "2-digit",
            month: "long",
        }).format(date);
    }

    fetchAllDevoirs();
});
