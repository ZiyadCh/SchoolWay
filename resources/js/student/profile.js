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
                Authorization: `Bearer ${getToken()}`,
            },
        });

        if (!response.ok) throw new Error("Fetch failed");

        const data = await response.json();

        updateUI(data);
    } catch (error) {
        console.error("Profile error:", error);
        const nameEl = document.getElementById("user-fullname");
        console.log(nameEl);
        if (nameEl) nameEl.textContent = "ERREUR DE CHARGEMENT";
    }
}

function updateUI(data) {
    const user = data.user || data;

    document.getElementById("user-fullname").textContent =
        `${user.prenom} ${user.nom}`;

    const birthDate = user.birthday
        ? new Date(user.birthday).toLocaleDateString("fr-FR")
        : "--/--/----";
    const joinedDate = user.created_at
        ? new Date(user.created_at).toLocaleDateString("fr-FR")
        : "--/--/----";

    document.getElementById("user-birth-info").textContent = birthDate;
    document.getElementById("user-joined").textContent = joinedDate;
    document.getElementById("user-gender").textContent =
        user.gender === "M" ? "Masculin" : "Féminin";
    document.getElementById("user-phone").textContent = user.tel || "---";
    document.getElementById("user-address").textContent = user.adress || "---";
    document.getElementById("user-email").textContent = user.email || "---";

    const pfp = document.getElementById("user-avatar");
    if (user.photo) {
        pfp.src = `/storage/${user.photo}`;
    } else {
        pfp.src = `/images/default.jpeg`;
    }
}
