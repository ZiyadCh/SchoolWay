import token from "../auth/token.js";

document.addEventListener("DOMContentLoaded", listStudents);

async function listStudents() {
    const tableBody = document.getElementById("student-table-body");
    const template = document.getElementById("student-row-template");

    try {
        const response = await fetch("/api/v1/students", {
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const students = await response.json();

        students.forEach((item) => {
            const user = item.user;
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

            // Handle Gender Badge
            //////////////////
            const badge = clone.querySelector(".student-gender");
            badge.textContent = user.gender;

            const genderClass =
                user.gender === "M" ? "text-blue-400" : "text-pink-400";
            const genderBg =
                user.gender === "M" ? "bg-blue-400/10" : "bg-pink-400/10";
            const genderBorder =
                user.gender === "M"
                    ? "border-blue-400/20"
                    : "border-pink-400/20";

            badge.classList.add(genderClass, genderBg, genderBorder);

            // Set Link
            //////////////////
            clone.querySelector(".student-link").href = `students/${item.id}`;

            tableBody.appendChild(clone);
        });
    } catch (error) {
        console.error("Could not load students:", error);
    }
}
