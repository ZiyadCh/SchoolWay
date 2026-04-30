const notesContainer = document.getElementById("notesContainer");

async function loadMyNotes() {
    if (!notesContainer) return;

    showLoading();

    try {
        const token = localStorage.getItem("token");
        const user = JSON.parse(localStorage.getItem("user"));

        if (!token || !user) throw new Error("Vous devez vous reconnecter");

        const inscriptions = user?.student?.inscriptions || [];
        if (inscriptions.length === 0)
            throw new Error("Aucune inscription active trouvée");

        const activeInscription = inscriptions.find(
            (ins) => ins.statut === "active",
        );
        const inscriptionId = activeInscription
            ? activeInscription.id
            : inscriptions[0].id;

        const examsResponse = await fetch(
            `/api/v1/exams?inscription_id=${inscriptionId}`,
            {
                headers: {
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
            },
        );

        if (!examsResponse.ok)
            throw new Error("Impossible de charger les notes");

        const result = await examsResponse.json();
        const exams = result.data || [];

        renderNotes(exams);
    } catch (error) {
        console.error("Error:", error);
        showError(error.message);
    }
}

function showLoading() {
    notesContainer.innerHTML = `
        <tr>
            <td colspan="3" class="p-10 text-center animate-pulse text-gray-500 uppercase font-black text-xs tracking-widest">
                Récupération des données...
            </td>
        </tr>
    `;
}

function showError(message) {
    notesContainer.innerHTML = `
        <tr>
            <td colspan="3" class="p-10 text-center text-red-500 uppercase font-black text-xs tracking-widest">
                ${message}
            </td>
        </tr>
    `;
}

function renderNotes(exams) {
    if (exams.length === 0) {
        notesContainer.innerHTML = `
            <tr>
                <td colspan="3" class="p-10 text-center text-gray-500 uppercase font-black text-xs tracking-widest">
                    Aucune note disponible pour le moment.
                </td>
            </tr>
        `;
        return;
    }

    notesContainer.innerHTML = exams
        .map((exam) => {
            const inscription = exam.inscriptions?.[0];
            const valeur = inscription?.pivot?.valeur;
            const grade =
                valeur !== undefined && valeur !== null
                    ? Number(valeur).toFixed(2)
                    : "---";
            const gradeColor = valeur >= 15 ? "text-amber-500" : "text-white";

            const date = exam.date
                ? new Date(exam.date).toLocaleDateString("fr-FR", {
                      day: "2-digit",
                      month: "long",
                      year: "numeric",
                  })
                : "Non définie";

            return `
            <tr class="hover:bg-gray-800/30 transition-colors group">
                <td class="p-6 font-bold text-gray-200 uppercase tracking-tight">${exam.title}</td>
                <td class="p-6 text-sm font-bold text-gray-400 uppercase italic">${date}</td>
                <td class="p-6 text-right font-black ${gradeColor} text-xl">${grade}</td>
            </tr>
        `;
        })
        .join("");
}

document.addEventListener("DOMContentLoaded", loadMyNotes);
