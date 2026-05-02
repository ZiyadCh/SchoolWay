const token = localStorage.getItem("token");

document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("main-sidebar");
    const overlay = document.getElementById("sidebar-overlay");
    const openBtn = document.getElementById("sidebar-open");
    const closeBtn = document.getElementById("sidebar-close");

    const toggleSidebar = () => {
        sidebar.classList.toggle("-translate-x-full");
        overlay.classList.toggle("hidden");
        document.body.classList.toggle("overflow-hidden");
    };

    [openBtn, closeBtn, overlay].forEach((btn) => {
        if (btn) btn.addEventListener("click", toggleSidebar);
    });

    loadYears();
});

async function loadYears() {
    const select = document.getElementById("year-select");
    if (!select) return;

    try {
        const response = await fetch("/api/v1/years", {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });

        if (!response.ok) throw new Error();

        const result = await response.json();
        const years = result.data || [];

        select.replaceChildren();

        years.forEach((year) => {
            const option = document.createElement("option");
            option.value = year.id;
            option.textContent = year.title;
            if (year.selected) option.selected = true;
            select.appendChild(option);
        });

        select.addEventListener("change", () => selectYear(select.value));
    } catch (e) {
        console.error("Erreur chargement années:", e);
    }
}

async function selectYear(yearId) {
    try {
        const response = await fetch(`/api/v1/years/${yearId}/select`, {
            method: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });

        if (!response.ok) throw new Error();

        window.location.reload();
    } catch (e) {
        console.error("Erreur sélection année:", e);
    }
}
