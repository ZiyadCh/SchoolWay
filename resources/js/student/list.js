import token from "../auth/token.js";
import updatePagination from "../core/pagination.js";

let nextUrl = null;
let prevUrl = null;

document.addEventListener("DOMContentLoaded", () => {
    fetchStudents("/api/v1/students");

    document.getElementById("next-page").onclick = () =>
        nextUrl && fetchStudents(nextUrl);
    document.getElementById("prev-page").onclick = () =>
        prevUrl && fetchStudents(prevUrl);
});

////////////////////////////
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

////////////////////////////
function renderTable(students) {
    const tableBody = document.getElementById("student-table-body");
    const template = document.getElementById("student-row-template");

    tableBody.innerHTML = "";

    students.forEach((student) => {
        if (!student) return;

        const clone = template.content.cloneNode(true);

        const user = student.user;
        const id = student.id;
        const isMale = user.gender === "M";

        const levelName =
            student.inscriptions?.[0]?.school_classes?.[0]?.level?.name ||
            "Non Definé";

        clone.querySelector(".student-name").textContent =
            `${user.prenom} ${user.nom}`;
        clone.querySelector(".student-level").textContent = levelName;
        clone.querySelector(".student-location").textContent =
            user.birthplace || "Non Definé";
        clone.querySelector(".student-link").href = `students/${id}`;

        clone.querySelector(".student-avatar").src = user.photo;

        const badge = clone.querySelector(".student-gender");
        badge.textContent = user.gender;
        badge.classList.add(
            isMale ? "text-blue-400" : "text-pink-400",
            isMale ? "bg-blue-400/10" : "bg-pink-400/10",
        );

        tableBody.appendChild(clone);
    });
}
