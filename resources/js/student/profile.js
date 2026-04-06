const token = localStorage.getItem("token");
document.addEventListener("DOMContentLoaded", () => {
    fetchUserData();
});

async function fetchUserData() {
    try {
        const response = await fetch("/api/user", {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                Authorization: `Bearer ${token}`,
                credentials: "include",
            },
        });

        if (!response.ok) {
            const text = await response.text();
            console.error("API ERROR:", response.status, text);
            throw new Error("Request failed");
        }

        const data = await response.json();
        updateUI(data);
    } catch (error) {
        const nameEl = document.getElementById("user-fullname");
        if (nameEl) nameEl.textContent = "ERREUR DE CHARGEMENT";
    }
}
function updateUI(user) {
    const fullName = `${user.prenom} ${user.nom}`;
    const birthDate = new Date(user.birthday).toLocaleDateString("fr-FR");

    document.getElementById("user-fullname").textContent = fullName;
    document.getElementById("user-class").textContent =
        user.role === "student" ? "Étudiant" : user.role;
    document.getElementById("user-id").textContent = user.id;
    document.getElementById("user-birth-info").textContent = `${birthDate}`;
    document.getElementById("user-gender").textContent =
        user.gender === "M" ? "Masculin" : "Féminin";
    document.getElementById("user-phone").textContent = user.tel || "---";
    document.getElementById("user-address").textContent = user.adress || "---";

    const pfp = document.getElementById("user-avatar");
    pfp.src = user.photo;
}

function calculateAge(birthday) {
    const birthDate = new Date(birthday);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const m = today.getMonth() - birthDate.getMonth();
    const isUnderAge =
        m < 0 || (m === 0 && today.getDate() < birthDate.getDate());
    return isUnderAge ? age - 1 : age;
}

window.switchTab = function (event, tabId) {
    document.querySelectorAll(".tab-content").forEach((c) => {
        c.classList.add("hidden", "opacity-0");
    });

    document.querySelectorAll(".tab-btn").forEach((b) => {
        b.classList.remove(
            "bg-amber-500",
            "text-black",
            "shadow-lg",
            "shadow-amber-500/20",
        );
        b.classList.add("text-gray-500", "hover:text-white");
    });

    const target = document.getElementById(tabId);
    target.classList.remove("hidden");
    setTimeout(() => target.classList.remove("opacity-0"), 10);

    const btn = event.currentTarget;
    btn.classList.add(
        "bg-amber-500",
        "text-black",
        "shadow-lg",
        "shadow-amber-500/20",
    );
    btn.classList.remove("text-gray-500", "hover:text-white");
};
