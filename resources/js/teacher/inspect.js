import token from "../auth/token.js";

const url_link = window.location.pathname.split("/");
const teacher_id = url_link.pop();

document.addEventListener("DOMContentLoaded", () => {
    loadTeacherProfile();
});

////////////////////////////
async function loadTeacherProfile() {
    try {
        const response = await fetch(`/api/v1/teachers/${teacher_id}`, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                Authorization: `Bearer ${token}`,
            },
        });

        if (!response.ok)
            throw new Error("Erreur lors de la récupération du profil");

        const result = await response.json();
        // On adapte selon si ton API renvoie { data: {...} } ou directement l'objet
        const teacherData = result.data || result;

        updateUI(teacherData);
    } catch (e) {
        console.error("Erreur profil enseignant:", e);
        document.getElementById("user-fullname").textContent = "ERREUR";
    }
}

////////////////////////////
function updateUI(teacher) {
    // Si tes données sont nichées dans un objet 'user' au sein de 'teacher'
    const info = teacher.user || teacher;
    const fallback = "Non renseigné";

    // 1. Identité et Photo
    const fullName =
        info.prenom && info.nom
            ? `${info.prenom} ${info.nom}`
            : info.name || "Enseignant";

    document.getElementById("user-fullname").textContent =
        fullName.toUpperCase();

    const avatarEl = document.getElementById("user-avatar");
    avatarEl.src = info.photo
        ? `/storage/${info.photo}`
        : `/images/default.jpeg`;

    // 2. Champs de la grille (Spécialité, Phone, Office, Ville, Email)
    // On mappe les IDs HTML avec les clés de ton API
    const fields = {
        "user-specialty": teacher.specialty || info.specialite,
        "user-phone": info.tel || info.phone,
        "user-office": teacher.bureau || teacher.office_number,
        "user-address": info.ville || info.city,
        "user-email": info.email,
    };

    Object.entries(fields).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (el) {
            if (value) {
                el.textContent = value;
                el.classList.remove("opacity-50", "italic");
            } else {
                el.textContent = fallback;
                el.classList.add("opacity-50", "italic", "font-medium");
            }
        }
    });

    // 3. Date d'intégration
    const joinedEl = document.getElementById("user-joined");
    const dateValue = teacher.hiring_date || info.created_at;

    if (dateValue) {
        const date = new Date(dateValue);
        joinedEl.textContent = `Intégré le ${date.toLocaleDateString("fr-FR", {
            day: "numeric",
            month: "long",
            year: "numeric",
        })}`;
        joinedEl.classList.remove("opacity-50", "italic");
    } else {
        joinedEl.textContent = fallback;
        joinedEl.classList.add("opacity-50", "italic");
    }
}
