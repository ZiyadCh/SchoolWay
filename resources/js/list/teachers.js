import token from "../auth/token.js";
import updatePagination from "../core/pagination.js";

let nextUrl = null;
let prevUrl = null;
let currentUrl = "/api/v1/teachers";

document.addEventListener("DOMContentLoaded", () => {
    fetchTeachers(currentUrl);

    document.getElementById("next-page").onclick = () =>
        nextUrl && fetchTeachers(nextUrl);
    document.getElementById("prev-page").onclick = () =>
        prevUrl && fetchTeachers(prevUrl);

    // Search functionality
    document.getElementById("search-btn").onclick = performSearch;
    document
        .getElementById("search-input")
        .addEventListener("keypress", (e) => {
            if (e.key === "Enter") performSearch();
        });
});

function performSearch() {
    const searchQuery = document
        .getElementById("search-input")
        .value.charAt(0)
        .toUpperCase()
        .trim();

    let url = "/api/v1/teachers?";

    if (searchQuery) {
        url += `search=${encodeURIComponent(searchQuery)}&`;
    }

    currentUrl = url.endsWith("&") ? url.slice(0, -1) : url;
    fetchTeachers(currentUrl);
}

async function fetchTeachers(url) {
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
        updatePagination(result, fetchTeachers);
    } catch (e) {
        console.error("Fetch failed", e);
    }
}

function renderTable(teachers) {
    const tableBody = document.getElementById("teacher-table-body");
    const template = document.getElementById("teacher-row-template");
    tableBody.innerHTML = "";

    if (teachers.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="5" class="px-8 py-10 text-center text-gray-500 uppercase text-xs tracking-widest">AUCUN ENSEIGNANT TROUVÉ</td></tr>`;
        return;
    }

    teachers.forEach((teacher) => {
        if (!teacher) return;

        const clone = template.content.cloneNode(true);
        const user = teacher.user;
        const id = teacher.id;

        clone.querySelector(".teacher-name").textContent =
            `${user.prenom} ${user.nom}`;
        clone.querySelector(".teacher-email").textContent =
            user.email || "Non Défini";
        clone.querySelector(".teacher-phone").textContent =
            user.tel || "Non Défini";

        // Detail link
        clone.querySelector(".teacher-link").href = `teachers/${id}`;

        const avatar = clone.querySelector(".teacher-photo");
        avatar.src = user.photo
            ? `/storage/${user.photo}`
            : "/images/default.jpeg";

        tableBody.appendChild(clone);
    });
}
