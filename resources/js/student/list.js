import token from "../auth/token.js";

let nextUrl = null;
let prevUrl = null;

document.addEventListener("DOMContentLoaded", () => {
    fetchStudents("/api/v1/students");

    document.getElementById("next-page").addEventListener("click", () => {
        if (nextUrl) fetchStudents(nextUrl);
    });

    document.getElementById("prev-page").addEventListener("click", () => {
        if (prevUrl) fetchStudents(prevUrl);
    });
});

async function fetchStudents(url) {
    const tableBody = document.getElementById("student-table-body");
    const template = document.getElementById("student-row-template");

    if (!tableBody || !template) return;

    try {
        const response = await fetch(url, {
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const result = await response.json();
        const students = result.data;

        nextUrl = result.next_page_url;
        prevUrl = result.prev_page_url;

        tableBody.innerHTML = "";

        students.forEach((item) => {
            const user = item.user;
            if (!user) return;

            const clone = template.content.cloneNode(true);

            clone.querySelector(".student-name").textContent =
                `${user.prenom} ${user.nom}`;
            clone.querySelector(".student-level").textContent =
                item.level || "N/A";
            clone.querySelector(".student-location").textContent =
                user.birthplace || "N/A";

            const avatar = user.photo
                ? `/storage/${user.photo}`
                : `https://api.dicebear.com/7.x/avataaars/svg?seed=${user.prenom}`;
            clone.querySelector(".student-avatar").src = avatar;

            const badge = clone.querySelector(".student-gender");
            badge.textContent = user.gender;
            const isMale = user.gender === "M";
            badge.classList.add(
                isMale ? "text-blue-400" : "text-pink-400",
                isMale ? "bg-blue-400/10" : "bg-pink-400/10",
                isMale ? "border-blue-400/20" : "border-pink-400/20",
            );

            clone.querySelector(".student-link").href = `students/${item.id}`;
            tableBody.appendChild(clone);
        });

        updatePaginationUI(result);
    } catch (error) {
        console.error(error);
    }
}

function updatePaginationUI(result) {
    const prevBtn = document.getElementById("prev-page");
    const nextBtn = document.getElementById("next-page");
    const pageNumbersContainer = document.getElementById("page-numbers");

    prevBtn.style.opacity = prevUrl ? "1" : "0.3";
    prevBtn.style.pointerEvents = prevUrl ? "auto" : "none";

    nextBtn.style.opacity = nextUrl ? "1" : "0.3";
    nextBtn.style.pointerEvents = nextUrl ? "auto" : "none";

    pageNumbersContainer.innerHTML = "";

    const startPage = Math.max(1, result.current_page - 1);
    const endPage = Math.min(result.last_page, startPage + 2);

    for (let i = startPage; i <= endPage; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = `w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg md:rounded-xl transition-all text-xs border ${
            i === result.current_page
                ? "bg-amber-500 text-black border-amber-500 shadow-lg shadow-amber-500/20"
                : "bg-gray-800 text-gray-400 hover:text-white border-gray-700"
        }`;

        btn.addEventListener("click", () => {
            if (i !== result.current_page) {
                fetchStudents(`/api/v1/students?page=${i}`);
            }
        });

        pageNumbersContainer.appendChild(btn);
    }
}
