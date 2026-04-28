const token = localStorage.getItem("token");
const url_link = window.location.pathname.split("/");
const user_id = url_link.pop();

document.addEventListener("DOMContentLoaded", () => {
    fetchAllStudentData();
});

async function fetchAllStudentData() {
    try {
        const profileRes = await fetchApi(`/api/v1/students/${user_id}`);
        const student = profileRes;
        console.log(student);
        updateUI(student);

        const inscriptionId = student.inscription?.id;
        if (!inscriptionId) return;

        const [notesRes, devoirsRes, absencesRes] = await Promise.all([
            fetchApi(`/api/v1/exams?inscription_id=${inscriptionId}`),
            fetchApi(`/api/v1/assignments?inscription_id=${inscriptionId}`),
            fetchApi(`/api/v1/absences?inscription_id=${inscriptionId}`),
        ]);

        renderNotes(notesRes.data || []);
        renderDevoirs(devoirsRes.data || []);
        renderAbsences(absencesRes.data || []);
    } catch (error) {
        console.error("Erreur globale:", error);
        document.getElementById("user-fullname").textContent =
            "ERREUR DE CHARGEMENT";
    }
}

// Helper pour simplifier les appels fetch
async function fetchApi(url) {
    const response = await fetch(url, {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
            Authorization: `Bearer ${token}`,
        },
    });
    if (!response.ok) throw new Error(`Erreur sur ${url}`);
    return await response.json();
}

function updateUI(student) {
    const user = student.user;
    document.getElementById("user-fullname").textContent =
        `${user.prenom} ${user.nom}`;
    document.getElementById("user-class").textContent =
        student.inscription?.school_class?.name || "";
    document.getElementById("user-id").textContent = student.id;
    document.getElementById("user-birth-info").textContent = user.birthday
        ? new Date(user.birthday).toLocaleDateString("fr-FR")
        : "";
    document.getElementById("user-gender").textContent =
        user.gender === "M" ? "Masculin" : "Féminin";
    document.getElementById("user-phone").textContent = user.tel || "";
    document.getElementById("user-address").textContent = user.adress || "";
    document.getElementById("user-email").textContent = user.email || "";
    document.getElementById("user-joined").textContent = new Date(
        user.created_at,
    ).toLocaleDateString("fr-FR");

    document.getElementById("user-avatar").src = user.photo
        ? user.photo
        : `/images/default.jpeg`;
}

function renderNotes(exams) {
    const container = document.getElementById("notes-container");
    if (exams.length === 0) {
        container.innerHTML = `<p class="col-span-full text-gray-600 text-center py-10 font-black text-[10px] uppercase tracking-widest">Aucune note</p>`;
        return;
    }

    container.innerHTML = exams
        .map(
            (exam) => `
        <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl flex flex-col justify-between h-40 hover:border-amber-500/30 transition-all group">
            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest leading-tight group-hover:text-white">
                ${exam.subject?.name || "Examen"}
            </h3>
            <div class="flex justify-between items-end">
                <span class="text-3xl font-black text-amber-500 tracking-tighter">${exam.pivot?.valeur || "N/A"}</span>
                <span class="text-[9px] font-black text-gray-700 uppercase tracking-widest mb-1">
                    ${new Date(exam.date).toLocaleDateString("fr-FR", { day: "numeric", month: "short" })}
                </span>
            </div>
        </div>
    `,
        )
        .join("");
}

function renderDevoirs(devoirs) {
    const container = document.getElementById("devoirs-container");
    if (devoirs.length === 0) {
        container.innerHTML = `<p class="col-span-full text-gray-600 text-center py-10 font-black text-[10px] uppercase tracking-widest">Aucun devoir</p>`;
        return;
    }

    container.innerHTML = devoirs
        .map(
            (devoir) => `
        <div class="relative bg-gray-900 rounded-xl p-10 pl-20 border border-gray-800 shadow-2xl group overflow-hidden">
            <div class="absolute left-6 top-0 bottom-0 flex flex-col justify-around py-10">
                ${Array(5).fill('<div class="w-4 h-4 rounded-full bg-gray-950 border-2 border-gray-800 group-hover:border-amber-500/30 transition-colors"></div>').join("")}
            </div>
            <span class="text-[14px] font-black text-amber-500 uppercase mb-4 block">${devoir.teacher?.user?.nom || "Enseignant"}</span>
            <p class="text-xl font-black text-gray-100 leading-tight">${devoir.description}</p>
            <div class="mt-8 flex items-center gap-4">
                <div class="h-px w-10 bg-red-500/50"></div>
                <span class="text-[12px] font-black text-red-500 uppercase tracking-widest">Limite : ${new Date(devoir.due_date).toLocaleDateString("fr-FR")}</span>
            </div>
        </div>
    `,
        )
        .join("");
}

function renderAbsences(absences) {
    const calendar = document.getElementById("absence-calendar");
    const monthDisplay = document.getElementById("current-month-display");

    const now = new Date();
    monthDisplay.textContent = now.toLocaleDateString("fr-FR", {
        month: "long",
        year: "numeric",
    });

    // On récupère les jours d'absence pour un marquage rapide
    const absentDays = absences.map((a) => new Date(a.date).getDate());
    const justifiedDays = absences
        .filter((a) => a.is_justified)
        .map((a) => new Date(a.date).getDate());

    // Génération simple des 31 jours (à adapter selon le mois si nécessaire)
    let html = calendar.innerHTML; // Garde les en-têtes Lun, Mar...
    for (let i = 1; i <= 31; i++) {
        const isAbsent = absentDays.includes(i);
        const isJustified = justifiedDays.includes(i);

        let statusClass = "border-gray-800/40 text-gray-600";
        let label = "";

        if (isAbsent) {
            statusClass = isJustified
                ? "bg-amber-500/10 border-amber-500/50 text-amber-500"
                : "bg-red-500/10 border-red-500/50 text-red-500";
            label = isJustified ? "Justifié" : "Absent";
        }

        html += `
            <div class="h-16 flex flex-col items-center justify-center rounded-lg border ${statusClass}">
                <span class="text-lg font-black">${i}</span>
                ${label ? `<span class="text-[7px] uppercase font-black tracking-tighter mt-1">${label}</span>` : ""}
            </div>
        `;
    }
    calendar.innerHTML = html;
}
