const token = localStorage.getItem("token");
const url_link = window.location.pathname.split("/");
const user_id = url_link.pop();

let currentDisplayedMonth = new Date().getMonth();
let currentDisplayedYear = new Date().getFullYear();

let studentData = null;
let cachedAbsences = null;
let cachedNotes = null;
let cachedDevoirs = null;

document.addEventListener("DOMContentLoaded", () => {
    loadProfile();
});

window.switchTab = async function (event, tabId) {
    const contents = document.querySelectorAll(".tab-content");
    const buttons = document.querySelectorAll(".tab-btn");

    contents.forEach((content) => {
        content.classList.add("hidden");
        content.classList.remove("opacity-100");
        content.classList.add("opacity-0");
    });

    const activeContent = document.getElementById(tabId);
    activeContent.classList.remove("hidden");
    setTimeout(() => activeContent.classList.add("opacity-100"), 10);

    buttons.forEach((btn) => {
        btn.classList.remove("bg-amber-500", "text-black");
        btn.classList.add("text-gray-500", "hover:text-white");
    });
    event.currentTarget.classList.add("bg-amber-500", "text-black");
    event.currentTarget.classList.remove("text-gray-500", "hover:text-white");

    handleDataLoading(tabId);
};

async function handleDataLoading(tabId) {
    switch (tabId) {
        case "notes":
            if (!cachedNotes) await loadExams();
            break;
        case "absence":
            if (!cachedAbsences) await loadAbsences();
            break;
        case "devoir":
            if (!cachedDevoirs) await loadAllDevoirs();
            break;
    }
}

async function loadProfile() {
    try {
        const res = await fetchApi(`/api/v1/students/${user_id}`);
        studentData = res.data || res;
        updateUI(studentData);
        await loadExams();
    } catch (e) {
        console.error("Erreur profil:", e);
    }
}

async function loadExams() {
    try {
        const res = await fetchApi(`/api/v1/exams?inscription_id=${user_id}`);
        cachedNotes = res.data || [];
        renderNotes(cachedNotes);
    } catch (e) {
        console.error(e);
    }
}

async function loadAbsences() {
    try {
        const res = await fetchApi(
            `/api/v1/absences?inscription_id=${user_id}`,
        );
        cachedAbsences = res.data || [];
        renderAbsences(cachedAbsences);
        setupCalendarNavigation();
    } catch (e) {
        console.error(e);
    }
}

async function loadAllDevoirs() {
    if (!studentData || !studentData.classes) return;
    try {
        const requests = studentData.classes.map((c) =>
            fetchApi(`/api/v1/devoirs?school_class_id=${c.id}`),
        );
        const results = await Promise.all(requests);
        cachedDevoirs = results.flatMap((res) => res.data || res);
        renderDevoirs(cachedDevoirs);
    } catch (e) {
        console.error(e);
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

    const fallback = "Non déterminé";

    document.getElementById("user-fullname").textContent =
        user.prenom && user.nom
            ? `${user.prenom} ${user.nom}`
            : "Utilisateur Inconnu";

    const birthInfo = document.getElementById("user-birth-info");
    birthInfo.textContent = user.birthday
        ? new Date(user.birthday).toLocaleDateString("fr-FR")
        : fallback;
    if (!user.birthday)
        birthInfo.classList.add("opacity-50", "italic", "font-medium");

    const genderEl = document.getElementById("user-gender");
    genderEl.textContent = user.gender
        ? user.gender === "M"
            ? "Masculin"
            : "Féminin"
        : fallback;
    genderEl.classList.add("opacity-50", "italic", "font-medium");

    const fields = {
        "user-phone": user.tel,
        "user-address": user.adress,
        "user-email": user.email,
    };

    Object.entries(fields).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (value) {
            el.textContent = value;
            el.classList.remove("opacity-50", "italic");
        } else {
            el.textContent = fallback;
            el.classList.add("opacity-50", "italic", "font-medium");
        }
    });

    document.getElementById("user-joined").textContent = user.created_at
        ? new Date(user.created_at).toLocaleDateString("fr-FR")
        : fallback;

    document.getElementById("user-avatar").src =
        `/storage/${user.photo}` || `/images/default.jpeg`;

    console.log(user.photo);
}

function renderNotes(exams) {
    const container = document.getElementById("notes-container");
    if (!container) return;
    container.replaceChildren();
    if (exams.length === 0) {
        container.innerHTML = `<p class="col-span-full text-gray-600 text-center py-10 text-[10px] uppercase font-black">Aucune note</p>`;
        return;
    }
    exams.forEach((exam) => {
        const pivot = exam.inscriptions?.[0]?.pivot;
        const card = document.createElement("div");
        card.className =
            "bg-gray-900 border border-gray-800 p-6 rounded-xl flex flex-col justify-between h-44 hover:border-amber-500/30 transition-all";
        card.innerHTML = `
            <div>
                <h3 class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1">${exam.subject?.name || "Matière"}</h3>
                <p class="text-sm font-bold text-gray-200 uppercase">${exam.title}</p>
            </div>
            <div class="flex justify-between items-end">
                <span class="text-3xl font-black text-white">${pivot ? pivot.valeur : "N/A"}</span>
                <span class="text-[9px] font-black text-gray-700 uppercase">${new Date(exam.date).toLocaleDateString("fr-FR", { day: "numeric", month: "short" })}</span>
            </div>`;
        container.appendChild(card);
    });
}

function renderDevoirs(devoirs) {
    const container = document.getElementById("devoirs-container");
    if (!container) return;
    container.replaceChildren();
    if (devoirs.length === 0) {
        container.innerHTML = `<p class="col-span-full text-gray-600 text-center py-10 text-[10px] uppercase font-black">Aucun devoir</p>`;
        return;
    }
    devoirs.forEach((d) => {
        const card = document.createElement("div");
        card.className =
            "bg-gray-900 border border-gray-800 p-6 rounded-xl hover:border-red-500/30 transition-all";
        card.innerHTML = `
            <h3 class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1">${d.title}</h3>
            <p class="text-sm text-gray-200 mb-4">${d.contenu}</p>
            <span class="text-[9px] font-black text-gray-500 uppercase">Échéance : ${new Date(d.deadline).toLocaleDateString("fr-FR")}</span>`;
        container.appendChild(card);
    });
}

function renderAbsences(absences) {
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
    ).toLocaleDateString("fr-FR", { month: "long", year: "numeric" });

    ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"].forEach((d) => {
        const h = document.createElement("div");
        h.className =
            "text-center text-[10px] font-black text-gray-700 uppercase mb-4";
        h.textContent = d;
        calendar.appendChild(h);
    });

    for (let i = 0; i < startOffset; i++)
        calendar.appendChild(document.createElement("div"));

    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${currentDisplayedYear}-${String(currentDisplayedMonth + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
        const abs = absences.find((a) => a.date === dateStr);
        const dayEl = document.createElement("div");
        dayEl.className =
            "h-16 flex flex-col items-center justify-center rounded-lg border border-gray-800/40 text-gray-600";
        dayEl.innerHTML = `<span class="text-lg font-black">${day}</span>`;
        if (abs) {
            const isJustified = abs.justifié;
            dayEl.className = isJustified
                ? "h-16 flex flex-col items-center justify-center rounded-lg border bg-emerald-500/10 border-emerald-500/50 text-emerald-500"
                : "h-16 flex flex-col items-center justify-center rounded-lg border bg-red-500/10 border-red-500/50 text-red-500";
            dayEl.innerHTML += `<span class="text-[7px] uppercase font-black mt-1">${isJustified ? "Justifié" : "Absent"}</span>`;
        }
        calendar.appendChild(dayEl);
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
