const token = localStorage.getItem("token");
const url_link = window.location.pathname.split("/");
const user_id = url_link.pop();

let currentDisplayedMonth = new Date().getMonth();
let currentDisplayedYear = new Date().getFullYear();
let cachedAbsences = [];

document.addEventListener("DOMContentLoaded", () => {
    fetchAllStudentData();
});

async function fetchAllStudentData() {
    try {
        const profileRes = await fetchApi(`/api/v1/students/${user_id}`);
        updateUI(profileRes.data || profileRes);

        const [notesRes, absencesRes] = await Promise.all([
            fetchApi(`/api/v1/exams?inscription_id=${user_id}`),
            fetchApi(`/api/v1/absences?inscription_id=${user_id}`),
        ]);

        cachedAbsences = absencesRes.data || [];
        renderNotes(notesRes.data || []);
        renderAbsences(cachedAbsences);
        setupCalendarNavigation();
    } catch (error) {
        console.error("Erreur :", error);
    }
}

function setupCalendarNavigation() {
    const btnPrev = document.getElementById("prev-month");
    const btnNext = document.getElementById("next-month");

    if (btnPrev && btnNext) {
        btnPrev.onclick = () => {
            currentDisplayedMonth--;
            if (currentDisplayedMonth < 0) {
                currentDisplayedMonth = 11;
                currentDisplayedYear--;
            }
            renderAbsences(cachedAbsences);
        };
        btnNext.onclick = () => {
            currentDisplayedMonth++;
            if (currentDisplayedMonth > 11) {
                currentDisplayedMonth = 0;
                currentDisplayedYear++;
            }
            renderAbsences(cachedAbsences);
        };
    }
}

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
    if (!user) return;

    document.getElementById("user-fullname").textContent =
        `${user.prenom} ${user.nom}`;
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
    document.getElementById("user-avatar").src =
        user.photo || `/images/default.jpeg`;
}

function renderNotes(exams) {
    const container = document.getElementById("notes-container");
    if (!container) return;
    container.replaceChildren();

    if (exams.length === 0) {
        const empty = document.createElement("p");
        empty.className =
            "col-span-full text-gray-600 text-center py-10 font-black text-[10px] uppercase tracking-widest";
        empty.textContent = "Aucune note";
        container.appendChild(empty);
        return;
    }

    exams.forEach((exam) => {
        const pivot = exam.inscriptions?.[0]?.pivot;
        const noteValue = pivot ? pivot.valeur : "N/A";

        const card = document.createElement("div");
        card.className =
            "bg-gray-900 border border-gray-800 p-6 rounded-xl flex flex-col justify-between h-44 hover:border-amber-500/30 transition-all group";

        const top = document.createElement("div");
        const subject = document.createElement("h3");
        subject.className =
            "text-[10px] font-black text-amber-500 uppercase tracking-widest leading-tight mb-1";
        subject.textContent = exam.subject?.name || "Matière";

        const title = document.createElement("p");
        title.className =
            "text-sm font-bold text-gray-200 uppercase tracking-tighter line-clamp-1";
        title.textContent = exam.title || "Examen sans titre";

        top.append(subject, title);

        const bottom = document.createElement("div");
        bottom.className = "flex justify-between items-end mt-4";

        const note = document.createElement("span");
        note.className = "text-3xl font-black text-white tracking-tighter";
        note.textContent = noteValue;

        const date = document.createElement("span");
        date.className =
            "text-[9px] font-black text-gray-700 uppercase tracking-widest mb-1";
        date.textContent = new Date(exam.date).toLocaleDateString("fr-FR", {
            day: "numeric",
            month: "short",
        });

        bottom.append(note, date);
        card.append(top, bottom);
        container.appendChild(card);
    });
}

function renderAbsences(absences) {
    console.log(absences);
    const calendar = document.getElementById("absence-calendar");
    const monthDisplay = document.getElementById("current-month-display");
    if (!calendar || !monthDisplay) return;

    calendar.replaceChildren();

    const firstDay = new Date(
        currentDisplayedYear,
        currentDisplayedMonth,
        1,
    ).getDay();
    const daysInMonth = new Date(
        currentDisplayedYear,
        currentDisplayedMonth + 1,
        0,
    ).getDate();
    const startOffset = firstDay === 0 ? 6 : firstDay - 1;

    monthDisplay.textContent = new Date(
        currentDisplayedYear,
        currentDisplayedMonth,
    ).toLocaleDateString("fr-FR", {
        month: "long",
        year: "numeric",
    });

    const filtered = absences.filter((a) => {
        const d = new Date(a.date);
        return (
            d.getMonth() === currentDisplayedMonth &&
            d.getFullYear() === currentDisplayedYear
        );
    });

    const absentDays = filtered.map((a) => new Date(a.date).getDate());
    const justifiedDays = filtered
        .filter((a) => a.justifié)
        .map((a) => new Date(a.date).getDate());

    ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"].forEach((dayStr) => {
        const header = document.createElement("div");
        header.className =
            "text-center text-[10px] font-black text-gray-700 uppercase mb-4";
        header.textContent = dayStr;
        calendar.appendChild(header);
    });

    for (let i = 0; i < startOffset; i++) {
        const empty = document.createElement("div");
        empty.className = "h-16 border border-transparent";
        calendar.appendChild(empty);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const isAbsent = absentDays.includes(day);
        const isJustified = justifiedDays.includes(day);

        const dayEl = document.createElement("div");
        dayEl.className =
            "h-16 flex flex-col items-center justify-center rounded-lg border border-gray-800/40 text-gray-600";

        const num = document.createElement("span");
        num.className = "text-lg font-black";
        num.textContent = day;
        dayEl.appendChild(num);

        if (isAbsent) {
            dayEl.className = isJustified
                ? "h-16 flex flex-col items-center justify-center rounded-lg border bg-emerald-500/10 border-emerald-500/50 text-emerald-500"
                : "h-16 flex flex-col items-center justify-center rounded-lg border bg-red-500/10 border-red-500/50 text-red-500";

            const label = document.createElement("span");
            label.className = "text-[7px] uppercase font-black mt-1";
            label.textContent = isJustified ? "Justifié" : "Absent";
            dayEl.appendChild(label);
        }

        calendar.appendChild(dayEl);
    }
}
