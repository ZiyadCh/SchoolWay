import token from "../auth/token.js";
import updatePagination from "../core/pagination.js";

let nextUrl = null;
let prevUrl = null;
let currentUrl = "/api/v1/students";

const formatDisplay = (str) => {
    if (!str) return "";
    return str.trim();
};

document.addEventListener("DOMContentLoaded", () => {
    fetchLevels();
    fetchStudents(currentUrl);

    document.getElementById("search-btn").onclick = performSearch;
    document
        .getElementById("search-input")
        .addEventListener("keypress", (e) => {
            if (e.key === "Enter") performSearch();
        });
    document
        .getElementById("level-filter")
        .addEventListener("change", performSearch);

    document.getElementById("next-page").onclick = () =>
        nextUrl && fetchStudents(nextUrl);
    document.getElementById("prev-page").onclick = () =>
        prevUrl && fetchStudents(prevUrl);
});

async function fetchLevels() {
    try {
        const response = await fetch("/api/v1/levels", {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });
        const result = await response.json();
        const select = document.getElementById("level-filter");
        result.data.forEach((level) => {
            const option = document.createElement("option");
            option.value = level.id;
            option.textContent = formatDisplay(level.name);
            select.appendChild(option);
        });
    } catch (e) {
        console.error("Erreur chargement niveaux", e);
    }
}

function performSearch() {
    const search = document
        .getElementById("search-input")
        .value.charAt(0)
        .toUpperCase()
        .trim();
    const levelId = document.getElementById("level-filter").value;

    let url = "/api/v1/students?";

    if (search) {
        url += `search=${encodeURIComponent(search)}&`;
    }
    if (levelId) {
        url += `level_id=${levelId}&`;
    }

    currentUrl = url.endsWith("&") ? url.slice(0, -1) : url;
    fetchStudents(currentUrl);
}

async function fetchStudents(url) {
    try {
        const response = await fetch(url, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
        });
        const result = await response.json();
        nextUrl = result.next_page_url;
        prevUrl = result.prev_page_url;
        renderTable(result.data);
        updatePagination(result, fetchStudents);
    } catch (e) {
        console.error("Fetch failed", e);
    }
}

function renderTable(students) {
    const tableBody = document.getElementById("student-table-body");
    const template = document.getElementById("student-row-template");
    tableBody.innerHTML = "";

    if (students.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="5" class="px-8 py-10 text-center text-gray-500 text-xs tracking-widest">AUCUN ÉLÈVE TROUVÉ</td></tr>`;
        return;
    }

    students.forEach((student) => {
        if (!student) return;
        const clone = template.content.cloneNode(true);
        const user = student.user;
        const isMale = user.gender === "M";

        const avatar = clone.querySelector(".student-avatar");
        avatar.src = user.photo
            ? `/storage/${user.photo}`
            : "/images/default.jpeg";

        const levelName =
            student.inscriptions?.[0]?.school_classes?.[0]?.level?.name ||
            "NON DÉFINI";

        clone.querySelector(".student-name").textContent = formatDisplay(
            `${user.prenom} ${user.nom}`,
        );
        clone.querySelector(".student-level").textContent =
            formatDisplay(levelName);
        clone.querySelector(".student-location").textContent =
            formatDisplay(user.birthplace) || "NON DÉFINI";
        clone.querySelector(".student-link").href = `students/${student.id}`;

        const badge = clone.querySelector(".student-gender");
        badge.textContent = user.gender;
        badge.classList.add(
            isMale ? "text-blue-400" : "text-pink-400",
            isMale ? "bg-blue-400/10" : "bg-pink-400/10",
        );

        tableBody.appendChild(clone);
    });
}
