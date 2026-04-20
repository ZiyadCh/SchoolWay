import token from "../auth/token.js";
import updatePagination from "../core/pagination.js";

let nextUrl = null;
let prevUrl = null;

document.addEventListener("DOMContentLoaded", () => {
    fetchPayments("/api/v1/paiments/paiment-stats");

    document.getElementById("next-page").onclick = () =>
        nextUrl && fetchPayments(nextUrl);
    document.getElementById("prev-page").onclick = () =>
        prevUrl && fetchPayments(prevUrl);
});

////////////////////////////
async function fetchPayments(url) {
    try {
        const response = await fetch(url, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const result = await response.json();

        nextUrl = result.next_page_url || null;
        prevUrl = result.prev_page_url || null;

        renderTable(result.students);
        updatePagination(result, fetchPayments);
    } catch (e) {
        console.error("Fetch failed", e);
    }
}

////////////////////////////
function renderTable(students) {
    const tableBody = document.getElementById("payments-table-body");
    const template = document.getElementById("payment-row-template");

    tableBody.innerHTML = "";

    if (!students || !Array.isArray(students)) return;

    students.forEach((payment) => {
        if (!payment) return;

        const clone = template.content.cloneNode(true);
        const id = payment.id;
        const isPaid = payment.status === "À Jour";

        clone.querySelector(".student-name").textContent = payment.student_name;

        const statusText = clone.querySelector(".status-text");
        const statusBadge = clone.querySelector(".status-badge");
        const statusDot = clone.querySelector(".status-dot");
        //detail button
        clone.querySelector(".action-link").href = `paiments/detail/${id}`;

        statusText.textContent = isPaid ? "à jour" : "retard";

        if (isPaid) {
            statusBadge.classList.add(
                "text-emerald-400",
                "bg-emerald-400/10",
                "border-emerald-500/20",
            );
            statusDot.classList.add("bg-emerald-500");
        } else {
            statusBadge.classList.add(
                "text-red-400",
                "bg-red-400/10",
                "border-red-500/20",
            );
            statusDot.classList.add("bg-red-500");
        }

        tableBody.appendChild(clone);
    });
}
