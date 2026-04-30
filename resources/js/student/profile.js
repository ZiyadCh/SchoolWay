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
            },
            credentials: "include",
        });

        if (!response.ok) {
            const text = await response.text();
            console.error("API ERROR:", response.status, text);
            throw new Error("Request failed");
        }

        const data = await response.json();
        console.log(data);
        updateUI(data);
    } catch (error) {
        console.error("Fetch error:", error);
        const nameEl = document.getElementById("user-fullname");
        if (nameEl) nameEl.textContent = "ERREUR DE CHARGEMENT";
    }
}

function updateUI(user) {
    document.getElementById("user-fullname").textContent =
        `${user.prenom} ${user.nom}`;

    const birthDate = new Date(user.birthday).toLocaleDateString("fr-FR");
    const joinedDate = new Date(user.created_at).toLocaleDateString("fr-FR");

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
    }
}
