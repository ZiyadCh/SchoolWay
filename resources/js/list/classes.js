import token from "../auth/token.js";
import updatePagination from "../core/pagination.js";

let nextUrl = null;
let prevUrl = null;

document.addEventListener("DOMContentLoaded", () => {
    fetchClasses("/api/v1/school_classes");

    document.getElementById("next-page").onclick = () =>
        nextUrl && fetchClasses(nextUrl);
    document.getElementById("prev-page").onclick = () =>
        prevUrl && fetchClasses(prevUrl);
});

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

    classes.forEach((item) => {
        if (!item) return;
        console.log(item);

        const clone = template.content.cloneNode(true);

        clone.querySelector(".class-name").textContent = item.name;
        clone.querySelector(".class-level").textContent =
            item.level?.name || "Non Défini";
        clone.querySelector(".class-students-count").textContent =
            `${item.nbr_students || "aucun"} Élèves`;
        //detail button
        clone.querySelector(".class-link").href = `classes/${item.id}`;

        const teacherUser = item.teacher?.user;
        const nameEl = clone.querySelector(".teacher-name");
        const photoEl = clone.querySelector(".teacher-photo");
        console.log(photoEl);

        if (teacherUser.photo) {
            photoEl.src = `/storage/${teacherUser.photo}`;
        } else {
            photoEl.src = `/images/default.jpeg`;
        }
        if (teacherUser) {
            nameEl.textContent = ` ${teacherUser.nom} ${teacherUser.prenom}`;
        } else {
            nameEl.textContent = "Non Assigné";
            photoEl.src = `/images/default.jpeg`;
        }

        tableBody.appendChild(clone);
    });
}
