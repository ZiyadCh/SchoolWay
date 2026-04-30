// notes.js

const notesContainer = document.getElementById("notesContainer");
console.log(notesContainer);

/**
 * Load student's notes using existing Exam API
 */
async function loadMyNotes() {
    if (!notesContainer) return;

    showLoading();

    try {
        const token = localStorage.getItem("token");

        if (!token) {
            throw new Error("Vous devez vous reconnecter");
        }

        // Step 1: Get current user to retrieve student & inscription info
        const userResponse = await fetch("/api/user", {
            method: "GET",
            headers: {
                Accept: "application/json",
                Authorization: `Bearer ${token}`,
            },
        });

        if (!userResponse.ok) {
            throw new Error("Session expirée. Veuillez vous reconnecter.");
        }

        const user = await userResponse.json();

        // Get inscription_id (current one)
        let inscriptionId = null;

        if (
            user.student &&
            user.student.inscriptions &&
            user.student.inscriptions.length > 0
        ) {
            // Try to find current inscription
            const currentInscription = user.student.inscriptions.find(
                (ins) => ins.statut === "current",
            );
            inscriptionId = currentInscription
                ? currentInscription.id
                : user.student.inscriptions[0].id;
        }

        if (!inscriptionId) {
            throw new Error("Aucune inscription active trouvée");
        }

        // Step 2: Fetch exams using inscription_id (using your existing index method)
        const examsResponse = await fetch(
            `/api/v1/exams?inscription_id=${inscriptionId}`,
            {
                method: "GET",
                headers: {
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
            },
        );

        if (!examsResponse.ok) {
            throw new Error("Impossible de charger les notes");
        }

        const result = await examsResponse.json();
        const exams = result.data || [];

        renderNotes(exams);
    } catch (error) {
        console.error("Error:", error);
        showError(error.message);
    }
}

// ==================== Helper Functions ====================

function showLoading() {
    notesContainer.innerHTML = `
        <div class="col-span-full flex justify-center py-12">
            <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-amber-500"></div>
        </div>
    `;
}

function showError(message) {
    notesContainer.innerHTML = `
        <div class="col-span-full bg-red-900/30 border border-red-800 rounded-2xl p-8 text-center">
            <p class="text-red-400">${message}</p>
        </div>
    `;
}

function renderNotes(exams) {
    if (exams.length === 0) {
        notesContainer.innerHTML = `
            <div class="col-span-full bg-gray-900 border border-gray-800 rounded-2xl p-12 text-center">
                <p class="text-gray-400 text-lg">Aucune note disponible pour le moment.</p>
            </div>
        `;
        return;
    }

    let html = "";

    exams.forEach((exam) => {
        // Extract note from inscriptions (based on your current controller structure)
        const inscriptionData =
            exam.inscriptions && exam.inscriptions[0]
                ? exam.inscriptions[0]
                : null;
        const note =
            inscriptionData && inscriptionData.note
                ? inscriptionData.note
                : null;

        const grade =
            note && note.valeur !== undefined
                ? Number(note.valeur).toFixed(2)
                : "---";
        const gradeColor =
            note && note.valeur >= 15 ? "text-amber-500" : "text-white";

        html += `
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 hover:border-amber-500/50 transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-lg text-white">${exam.title}</h3>
                        <p class="text-amber-500 text-sm font-medium">
                            ${exam.subject ? exam.subject.name : "Matière inconnue"}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="text-4xl font-black ${gradeColor}">${grade}</span>
                    </div>
                </div>

                <div class="flex justify-between text-sm">
                    <div class="text-gray-400">
                        <span class="block text-[10px] uppercase tracking-widest">Enseignant</span>
                        ${
                            exam.teacher && exam.teacher.user
                                ? `${exam.teacher.user.nom} ${exam.teacher.user.prenom}`
                                : "Non assigné"
                        }
                    </div>
                    <div class="text-gray-400 text-right">
                        <span class="block text-[10px] uppercase tracking-widest">Date</span>
                        ${
                            exam.date
                                ? new Date(exam.date).toLocaleDateString(
                                      "fr-FR",
                                      {
                                          day: "numeric",
                                          month: "long",
                                          year: "numeric",
                                      },
                                  )
                                : "Non définie"
                        }
                    </div>
                </div>
            </div>
        `;
    });

    notesContainer.innerHTML = html;
}

// Initialize
document.addEventListener("DOMContentLoaded", loadMyNotes);
