document.addEventListener("DOMContentLoaded", () => {
    fetchDashboardData();
});

async function fetchDashboardData() {
    try {
        const [
            studentsRes,
            teachersRes,
            classesRes,
            paymentRes,
            levelsRes,
            subjectsRes,
            absencesRes,
        ] = await Promise.all([
            fetch("/api/v1/students?count"),
            fetch("/api/v1/teachers?count"),
            fetch("/api/v1/school_classes?count"),
            fetch("/api/v1/paiments/paiment-stats"),
            fetch("/api/v1/levels"),
            fetch("/api/v1/subjects"),
            fetch("/api/v1/absences?today=1"),
        ]);

        const studentsData = await studentsRes.json();
        const teachersData = await teachersRes.json();
        const classesData = await classesRes.json();
        const paymentData = await paymentRes.json();
        const levelsResData = await levelsRes.json();
        const subjectsResData = await subjectsRes.json();
        const absencesData = await absencesRes.json();

        updateStatsCards(studentsData, teachersData, classesData, paymentData);
        updateLevelsList(levelsResData);
        updateSubjectsList(subjectsResData);
        updateAbsencesList(absencesData);
    } catch (error) {
        console.error("Erreur lors du chargement du tableau de bord:", error);
        showErrorMessage();
    }
}

function updateStatsCards(
    studentsData,
    teachersData,
    classesData,
    paymentData,
) {
    const studentEl = document.querySelectorAll(".text-5xl.text-white.mt-1")[0];
    if (studentEl) studentEl.textContent = studentsData.total_students || 0;

    const teacherEl = document.querySelectorAll(".text-5xl.text-white.mt-1")[1];
    if (teacherEl) teacherEl.textContent = teachersData.total_teachers || 0;

    const classEl = document.querySelectorAll(".text-5xl.text-white.mt-1")[2];
    if (classEl) classEl.textContent = classesData.total_classes || 0;

    const paymentEl = document.querySelectorAll(".text-5xl.text-white.mt-1")[3];
    if (paymentEl) {
        const percentage =
            paymentData.percentage_paid !== undefined
                ? Math.round(paymentData.percentage_paid)
                : 0;
        paymentEl.textContent = `${percentage}%`;
    }
}

function updateLevelsList(response) {
    const container = document.querySelectorAll(
        ".grow.max-h-80.overflow-y-auto",
    )[0];
    if (!container) return;

    container.innerHTML = "";

    const levels = response.data || response || [];

    if (levels.length === 0) {
        const emptyDiv = document.createElement("div");
        emptyDiv.className =
            "p-5 bg-gray-900 border border-gray-700 rounded-xl text-lg text-gray-400";
        emptyDiv.textContent = "Aucun niveau trouvé";
        container.appendChild(emptyDiv);
        return;
    }

    levels.forEach((level) => {
        const div = document.createElement("div");
        div.className =
            "p-5 bg-gray-900 border border-gray-700 rounded-xl text-lg";
        div.textContent = level.name || level;
        container.appendChild(div);
    });
}

function updateSubjectsList(response) {
    const container = document.querySelectorAll(
        ".grow.max-h-80.overflow-y-auto",
    )[1];
    if (!container) return;

    container.innerHTML = "";

    const subjects = response.data || response || [];

    if (subjects.length === 0) {
        const emptyDiv = document.createElement("div");
        emptyDiv.className =
            "p-5 bg-gray-900 border border-gray-700 rounded-xl text-lg text-gray-400";
        emptyDiv.textContent = "Aucune matière trouvée";
        container.appendChild(emptyDiv);
        return;
    }

    subjects.forEach((subject) => {
        const div = document.createElement("div");
        div.className =
            "p-5 bg-gray-900 border border-gray-700 rounded-xl text-lg";
        div.textContent = subject.name || subject;
        container.appendChild(div);
    });
}

function updateAbsencesList(absences) {
    const container = document.querySelectorAll(
        ".grow.max-h-80.overflow-y-auto",
    )[2];
    if (!container) return;

    container.innerHTML = "";

    const absenceList = Array.isArray(absences)
        ? absences
        : absences.data || [];

    if (absenceList.length === 0) {
        const emptyDiv = document.createElement("div");
        emptyDiv.className =
            "p-5 bg-gray-900 border border-gray-700 rounded-xl text-lg text-gray-400 italic";
        emptyDiv.textContent = "Aucune absence aujourd'hui";
        container.appendChild(emptyDiv);
        return;
    }

    absenceList.forEach((abs) => {
        const div = document.createElement("div");
        div.className =
            "p-5 bg-gray-900 border border-gray-700 rounded-xl text-lg border-l-4 border-l-red-500";

        const studentName =
            abs.student_name ||
            (abs.inscription?.student?.user?.nom
                ? `${abs.inscription.student.user.nom} ${abs.inscription.student.user.prenom || ""}`.trim()
                : "Élève inconnu");

        const className =
            abs.class_name || abs.inscription?.school_class?.name || "";

        div.textContent = className
            ? `${studentName} (${className})`
            : studentName;

        container.appendChild(div);
    });
}

function showErrorMessage() {
    const errorDiv = document.createElement("div");
    errorDiv.className =
        "fixed bottom-6 right-6 bg-red-600 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 text-sm";
    errorDiv.textContent =
        "Erreur de chargement des données. Veuillez rafraîchir la page.";

    document.body.appendChild(errorDiv);

    setTimeout(() => {
        errorDiv.style.opacity = "0";
        setTimeout(() => errorDiv.remove(), 600);
    }, 4500);
}
