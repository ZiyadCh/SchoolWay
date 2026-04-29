import token from "../auth/token.js";
import updatePagination from "../core/pagination.js";

let nextUrl = null;
let prevUrl = null;

document.addEventListener("DOMContentLoaded", () => {
    fetchLevels();
    fetchClasses("/api/v1/school_classes");
    document.getElementById("search-btn").onclick = () => handleSearch();
    document.getElementById("search-input").onkeypress = (e) => {
        if (e.key === "Enter") handleSearch();
    };
    document.getElementById("level-filter").onchange = () => handleSearch();
    document.getElementById("next-page").onclick = () =>
        nextUrl && fetchClasses(nextUrl);
    document.getElementById("prev-page").onclick = () =>
        prevUrl && fetchClasses(prevUrl);
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
            option.textContent = level.name;
            select.appendChild(option);
        });
    } catch (e) {
        console.error("Erreur chargement niveaux", e);
    }
}

function handleSearch() {
    const search = document
        .getElementById("search-input")
        .value.charAt(0)
        .toUpperCase()
        .trim();
    const levelId = document.getElementById("level-filter").value;
    let url = `/api/v1/school_classes?search=${encodeURIComponent(search)}&regex=1`;
    if (levelId) url += `&level_id=${levelId}`;
    fetchClasses(url);
}

async function fetchClasses(url) {
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
        updatePagination(result, fetchClasses);
    } catch (e) {
        console.error("Fetch failed", e);
    }
}

function renderTable(classes) {
    const tableBody = document.getElementById("class-table-body");
    const template = document.getElementById("class-row-template");
    tableBody.innerHTML = "";
    if (classes.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="5" class="px-8 py-10 text-center text-gray-500 uppercase text-xs tracking-widest">Aucune classe trouvée</td></tr>`;
        return;
    }
    classes.forEach((item) => {
        if (!item) return;
        const clone = template.content.cloneNode(true);
        clone.querySelector(".class-name").textContent = item.name;
        clone.querySelector(".class-level").textContent =
            item.level?.name || "Non Défini";
        clone.querySelector(".class-students-count").textContent =
            `${item.nbr_students || 0} Élèves`;
        clone.querySelector(".class-link").href = `classes/${item.id}`;
        const teacherUser = item.teacher?.user;
        const nameEl = clone.querySelector(".teacher-name");
        const photoEl = clone.querySelector(".teacher-photo");
        if (teacherUser) {
            nameEl.textContent = `${teacherUser.nom} ${teacherUser.prenom}`;
            photoEl.src = teacherUser.photo
                ? `/storage/${teacherUser.photo}`
                : `/images/default.jpeg`;
        } else {
            nameEl.textContent = "Non Assigné";
            photoEl.src = `/images/default.jpeg`;
        }
        tableBody.appendChild(clone);
    });
}
