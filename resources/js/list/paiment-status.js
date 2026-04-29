import token from "../auth/token.js";
import updatePagination from "../core/pagination.js";

let nextUrl = null;
let prevUrl = null;
let currentUrl = "/api/v1/paiments/paiment-stats";

document.addEventListener("DOMContentLoaded", () => {
    fetchPayments(currentUrl);

    document.getElementById("next-page").onclick = () =>
        nextUrl && fetchPayments(nextUrl);
    document.getElementById("prev-page").onclick = () =>
        prevUrl && fetchPayments(prevUrl);

    document
        .getElementById("search-input")
        .addEventListener("keypress", (e) => {
            if (e.key === "Enter") performSearch();
        });

    const searchBtn =
        document.querySelector("button i.fa-search")?.parentElement;
    if (searchBtn) searchBtn.onclick = performSearch;

    document.getElementById("status-filter").onchange = performSearch;
});

function performSearch() {
    const search = document
        .getElementById("search-input")
        .value.charAt(0)
        .toUpperCase()
        .trim();
    const status = document.getElementById("status-filter").value;

    const params = new URLSearchParams();
    if (search) params.append("search", search);
    if (status !== "all") params.append("status", status);

    currentUrl = `/api/v1/paiments/paiment-stats?${params.toString()}`;
    fetchPayments(currentUrl);
}

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
        console.log(result.percentage_paid);

        nextUrl = result.next_page_url || null;
        prevUrl = result.prev_page_url || null;

        renderTable(result.students);
        updatePagination(result, fetchPayments);
    } catch (e) {
        console.error("Fetch failed", e);
    }
}

function renderTable(students) {
    const tableBody = document.getElementById("payments-table-body");
    const template = document.getElementById("payment-row-template");

    tableBody.innerHTML = "";

    if (!students || students.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="3" class="px-8 py-10 text-center text-gray-500 uppercase text-xs font-bold tracking-widest">Aucun résultat trouvé</td></tr>`;
        return;
    }

    students.forEach((payment) => {
        if (!payment) return;

        const clone = template.content.cloneNode(true);
        const id = payment.id;
        const isPaid = payment.status === "À Jour";

        // Photo
        const avatarImg = clone.querySelector(".student-photo");
        avatarImg.src = payment.student_photo
            ? `/storage/${payment.student_photo}`
            : `/images/default.jpeg`;

        // Infos textuelles
        clone.querySelector(".student-name").textContent = payment.student_name;

        // Lien vers détail
        clone.querySelector(".action-link").href = `paiments/detail/${id}`;

        // Badge Statut
        const statusText = clone.querySelector(".status-text");
        const statusBadge = clone.querySelector(".status-badge");
        const statusDot = clone.querySelector(".status-dot");

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
