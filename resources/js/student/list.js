import token from "../auth/token.js";

let nextUrl = null;
let prevUrl = null;

document.addEventListener("DOMContentLoaded", () => {
    fetchStudents("/api/v1/students");

    document.getElementById("next-page").onclick = () =>
        nextUrl && fetchStudents(nextUrl);
    document.getElementById("prev-page").onclick = () =>
        prevUrl && fetchStudents(prevUrl);
});

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
        renderTable(result.data);
        updatePagination(result);
    } catch (e) {
        console.error("Fetch failed", e);
    }
}

function renderTable(students) {
    const tableBody = document.getElementById("student-table-body");
    const template = document.getElementById("student-row-template");

    tableBody.innerHTML = "";

    students.forEach(({ id, level, user }) => {
        if (!user) return;

        const clone = template.content.cloneNode(true);
        const isMale = user.gender === "M";

        clone.querySelector(".student-name").textContent =
            `${user.prenom} ${user.nom}`;
        clone.querySelector(".student-level").textContent = level || "N/A";
        clone.querySelector(".student-location").textContent =
            user.birthplace || "N/A";
        clone.querySelector(".student-link").href = `students/${id}`;

        clone.querySelector(".student-avatar").src = user.photo
            ? `/storage/${user.photo}`
            : `https://api.dicebear.com/7.x/avataaars/svg?seed=${user.prenom}`;

        const badge = clone.querySelector(".student-gender");
        badge.textContent = user.gender;
        badge.classList.add(
            isMale ? "text-blue-400" : "text-pink-400",
            isMale ? "bg-blue-400/10" : "bg-pink-400/10",
            isMale ? "border-blue-400/20" : "border-pink-400/20",
        );

        tableBody.appendChild(clone);
    });
}

function updatePagination(res) {
    nextUrl = res.next_page_url;
    prevUrl = res.prev_page_url;

    const prevBtn = document.getElementById("prev-page");
    const nextBtn = document.getElementById("next-page");
    const container = document.getElementById("page-numbers");

    container.innerHTML = "";
    const start = Math.max(1, res.current_page - 1);
    const end = Math.min(res.last_page, start + 2);

    for (let i = start; i <= end; i++) {
        const active = i === res.current_page;
        const btn = document.createElement("button");

        btn.textContent = i;
        btn.className = `w-10 h-10 flex items-center justify-center rounded-xl transition-all text-xs border ${
            active
                ? "bg-amber-500 text-black border-amber-500 shadow-lg"
                : "bg-gray-800 text-gray-400 border-gray-700"
        }`;

        btn.onclick = () =>
            !active && fetchStudents(`/api/v1/students?page=${i}`);
        container.appendChild(btn);
    }
}
