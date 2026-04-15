import token from "../auth/token.js";
import updatePagination from "../core/pagination.js";
let nextUrl = null;
let prevUrl = null;
document.addEventListener("DOMContentLoaded", () => {
    fetchTeachers("/api/v1/teachers");
    document.getElementById("next-page").onclick = () =>
        nextUrl && fetchTeachers(nextUrl);
    document.getElementById("prev-page").onclick = () =>
        prevUrl && fetchTeachers(prevUrl);
});
////////////////////////////
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
////////////////////////////
function renderTable(teachers) {
    const tableBody = document.getElementById("teacher-table-body");
    const template = document.getElementById("teacher-row-template");
    tableBody.innerHTML = "";
    teachers.forEach((teacher) => {
        if (!teacher) return;
        const clone = template.content.cloneNode(true);
        const user = teacher.user;
        const id = teacher.id;
        clone.querySelector(".teacher-name").textContent =
            `${user.prenom} ${user.nom}`;
        clone.querySelector(".teacher-email").textContent =
            user.email || "Non Definé";
        clone.querySelector(".teacher-phone").textContent =
            user.tel || "Non Definé";
        clone.querySelector(".teacher-link").href = `teachers/${id}`;
        clone.querySelector(".teacher-photo").src = user.photo;
        tableBody.appendChild(clone);
    });
}
