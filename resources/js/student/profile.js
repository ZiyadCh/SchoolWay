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
        });

        if (!response.ok) throw new Error("Fetch failed");

        const data = await response.json();

        updateUI(data);

        renderClasses(data.classes || []);
    } catch (error) {
        console.error("Profile error:", error);
        const nameEl = document.getElementById("user-fullname");
        if (nameEl) nameEl.textContent = "ERREUR DE CHARGEMENT";
    }
}

function renderClasses(classes) {
    const container = document.getElementById("classes-container");

    // Handle both direct arrays or Laravel paginated objects
    const classesList = Array.isArray(classes) ? classes : classes.data || [];

    if (classesList.length === 0) {
        container.innerHTML = `<p class="text-gray-500 italic">Aucune classe assignée.</p>`;
        return;
    }

    container.innerHTML = classesList
        .map(
            (cls) => `
        <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl hover:border-amber-500/50 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] bg-amber-500/10 text-amber-500 px-2 py-1 rounded font-black uppercase tracking-widest border border-amber-500/20">
                    ${cls.level ? cls.level.name : "Niveau N/A"}
                </span>
                <div class="p-2 bg-gray-800 rounded-lg group-hover:bg-amber-500/10 transition-colors">
                    <i class="ri-book-open-line text-gray-500 group-hover:text-amber-500"></i>
                </div>
            </div>
            <h4 class="text-white font-bold text-lg uppercase tracking-tight">${cls.name}</h4>
            <div class="flex items-center gap-2 mt-3">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                <p class="text-gray-500 text-xs italic">Session Active</p>
            </div>
        </div>
    `,
        )
        .join("");
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
