const token = localStorage.getItem("token");
const url_parts = window.location.pathname.split("/");
// On suppose que l'URL est /students/{id}/edit, l'ID est donc l'avant-dernier segment
const user_id = url_parts[url_parts.length - 2];

document.addEventListener("DOMContentLoaded", () => {
    fetchCurrentData();
    setupEventListeners();
});

// 1. Récupérer les données existantes pour remplir le formulaire
async function fetchCurrentData() {
    try {
        const response = await fetch(`/api/v1/students/${user_id}`, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });
        const res = await response.json();
        const student = res.data || res;
        fillForm(student);
    } catch (e) {
        console.error("Erreur de chargement:", e);
    }
}

function fillForm(student) {
    const user = student.user;
    if (!user) return;

    // Remplissage des inputs
    document.getElementById("input-prenom").value = user.prenom || "";
    document.getElementById("input-nom").value = user.nom || "";

    if (user.birthday) {
        document.getElementById("input-birthday").value = new Date(
            user.birthday,
        )
            .toISOString()
            .split("T")[0];
    }

    document.getElementById("input-gender").value =
        user.gender === "M" ? "MALE" : "FEMALE";
    document.getElementById("input-phone").value = user.tel || "";
    document.getElementById("input-address").value = user.adress || "";
    document.getElementById("input-email").value = user.email || "";

    // Aperçu de l'image actuelle
    document.getElementById("preview-avatar").src = user.photo
        ? `/storage/${user.photo}`
        : `/images/default.jpeg`;
}

// 2. Écouteurs d'événements (Preview image et Submit)
function setupEventListeners() {
    const avatarInput = document.getElementById("avatar-upload");
    const editForm = document.getElementById("edit-student-form");

    // Preview de l'image quand on sélectionne un fichier
    if (avatarInput) {
        avatarInput.addEventListener("change", function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById("preview-avatar").src =
                        e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Gestion de la soumission
    if (editForm) {
        editForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            await saveProfile();
        });
    }
}

// 3. Sauvegarde vers l'API
async function saveProfile() {
    const submitBtn = document.getElementById("submit-btn");
    const originalText = submitBtn.innerHTML;

    // UI Loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = `<i class="fa-solid fa-spinner animate-spin"></i> Enregistrement...`;

    const formData = new FormData();

    // Method Spoofing pour Laravel (POST -> PUT)
    formData.append("_method", "PUT");

    // Construction du FormData
    formData.append("prenom", document.getElementById("input-prenom").value);
    formData.append("nom", document.getElementById("input-nom").value);
    formData.append(
        "birthday",
        document.getElementById("input-birthday").value,
    );
    formData.append(
        "gender",
        document.getElementById("input-gender").value === "MALE" ? "M" : "F",
    );
    formData.append("tel", document.getElementById("input-phone").value);
    formData.append("adress", document.getElementById("input-address").value);
    formData.append("email", document.getElementById("input-email").value);

    const photoFile = document.getElementById("avatar-upload").files[0];
    if (photoFile) {
        formData.append("photo", photoFile);
    }

    try {
        const response = await fetch(`/api/v1/students/${user_id}`, {
            method: "POST", // On utilise POST physiquement pour envoyer des fichiers
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
            body: formData,
        });

        if (response.ok) {
            alert("Profil mis à jour !");
            // Redirection vers la page profil après succès
            window.location.href = `/students/${user_id}`;
        } else {
            const errorData = await response.json();
            console.error("Erreurs:", errorData);
            alert("Erreur lors de la sauvegarde. Vérifiez les données.");
        }
    } catch (error) {
        console.error("Erreur réseau:", error);
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
}
