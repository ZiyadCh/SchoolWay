const token = localStorage.getItem("token");
const url_link = window.location.pathname.split("/");
const user_id = url_link.pop();

let teacherData = null;
let isEditMode = false;
let pendingAvatarFile = null;

document.addEventListener("DOMContentLoaded", () => {
    loadProfile();
    setupEditMode();
});

function setupEditMode() {
    const btnToggle = document.getElementById("btn-edit-toggle");
    const btnSave = document.getElementById("btn-save");
    const btnCancel = document.getElementById("btn-cancel");
    const btnDelete = document.getElementById("btn-delete-student"); // Selected from HTML
    const avatarInput = document.getElementById("avatar-input");

    btnToggle.addEventListener("click", () => enterEditMode());
    btnCancel.addEventListener("click", () => exitEditMode(false));
    btnSave.addEventListener("click", () => saveProfile());

    // Add delete listener
    if (btnDelete) {
        btnDelete.addEventListener("click", () => deleteTeacher());
    }

    avatarInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (!file) return;
        pendingAvatarFile = file;
        const reader = new FileReader();
        reader.onload = (ev) => {
            document.getElementById("user-avatar").src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });
}

function enterEditMode() {
    if (!teacherData) return;
    isEditMode = true;
    const user = teacherData.user;

    document.getElementById("edit-prenom").value = user.prenom || "";
    document.getElementById("edit-nom").value = user.nom || "";
    document.getElementById("edit-birthday").value = user.birthday
        ? user.birthday.slice(0, 10)
        : "";
    document.getElementById("edit-gender").value = user.gender || "";
    document.getElementById("edit-tel").value = user.tel || "";
    document.getElementById("edit-adress").value = user.adress || "";
    document.getElementById("edit-email").value = user.email || "";

    document.getElementById("user-fullname").classList.add("hidden");
    document.getElementById("edit-name-fields").classList.remove("hidden");
    document.getElementById("avatar-upload-label").classList.remove("hidden");

    document
        .querySelectorAll(".view-field")
        .forEach((el) => el.classList.add("hidden"));
    document
        .querySelectorAll(".edit-field")
        .forEach((el) => el.classList.remove("hidden"));

    document.getElementById("btn-edit-toggle").classList.add("hidden");
    document.getElementById("btn-save").classList.remove("hidden");
    document.getElementById("btn-cancel").classList.remove("hidden");

    // Show delete button
    const btnDelete = document.getElementById("btn-delete-student");
    if (btnDelete) btnDelete.classList.remove("hidden");

    hideFeedback();
}

function exitEditMode(saved) {
    isEditMode = false;
    pendingAvatarFile = null;

    document.getElementById("user-fullname").classList.remove("hidden");
    document.getElementById("edit-name-fields").classList.add("hidden");
    document.getElementById("avatar-upload-label").classList.add("hidden");

    document
        .querySelectorAll(".view-field")
        .forEach((el) => el.classList.remove("hidden"));
    document
        .querySelectorAll(".edit-field")
        .forEach((el) => el.classList.add("hidden"));

    document.getElementById("btn-edit-toggle").classList.remove("hidden");
    document.getElementById("btn-save").classList.add("hidden");
    document.getElementById("btn-cancel").classList.add("hidden");

    // Hide delete button
    const btnDelete = document.getElementById("btn-delete-student");
    if (btnDelete) btnDelete.classList.add("hidden");

    if (!saved && teacherData) {
        updateUI(teacherData);
    }
}

async function saveProfile() {
    const btnSave = document.getElementById("btn-save");
    btnSave.disabled = true;
    btnSave.innerHTML = `<span class="text-black"><i class="fa-solid fa-spinner fa-spin"></i></span><span class="text-[11px] font-black uppercase tracking-widest text-black">Sauvegarde...</span>`;

    try {
        const payload = new FormData();
        payload.append(
            "prenom",
            document.getElementById("edit-prenom").value.trim(),
        );
        payload.append("nom", document.getElementById("edit-nom").value.trim());
        payload.append(
            "birthday",
            document.getElementById("edit-birthday").value,
        );
        payload.append("gender", document.getElementById("edit-gender").value);
        payload.append("tel", document.getElementById("edit-tel").value.trim());
        payload.append(
            "adress",
            document.getElementById("edit-adress").value.trim(),
        );
        payload.append(
            "email",
            document.getElementById("edit-email").value.trim(),
        );
        payload.append("_method", "PUT");

        if (pendingAvatarFile) {
            payload.append("photo", pendingAvatarFile);
        }

        const res = await fetch(`/api/v1/teachers/${user_id}`, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: payload,
        });

        const data = await res.json();

        if (!res.ok) {
            const messages = data.errors
                ? Object.values(data.errors).flat().join(" — ")
                : data.message || "Erreur lors de la sauvegarde.";
            showFeedback(messages, "error");
            return;
        }

        teacherData = data.data || data;
        updateUI(teacherData);
        exitEditMode(true);
        showFeedback("Profil mis à jour avec succès !", "success");
    } catch (e) {
        console.error("Save error:", e);
        showFeedback("Erreur réseau. Veuillez réessayer.", "error");
    } finally {
        btnSave.disabled = false;
        btnSave.innerHTML = `<span class="text-black"><i class="fa-solid fa-floppy-disk"></i></span><span class="text-[11px] font-black uppercase tracking-widest text-black">Sauvegarder</span>`;
    }
}

async function deleteTeacher() {
    if (
        !confirm(
            "Êtes-vous sûr de vouloir supprimer ce compte enseignant ? Cette action est irréversible.",
        )
    ) {
        return;
    }

    const btnDelete = document.getElementById("btn-delete-student");
    const originalHTML = btnDelete.innerHTML;

    btnDelete.disabled = true;
    btnDelete.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span class="text-[10px]">Suppression...</span>`;

    try {
        const res = await fetch(`/api/v1/teachers/${user_id}`, {
            method: "DELETE",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                Authorization: `Bearer ${token}`,
            },
        });

        if (res.ok) {
            window.location.href = document.referrer;
        } else {
            const data = await res.json();
            showFeedback(
                data.message || "Erreur lors de la suppression.",
                "error",
            );
            btnDelete.disabled = false;
            btnDelete.innerHTML = originalHTML;
        }
    } catch (e) {
        console.error("Delete error:", e);
        showFeedback("Erreur réseau. Impossible de supprimer.", "error");
        btnDelete.disabled = false;
        btnDelete.innerHTML = originalHTML;
    }
}

async function loadProfile() {
    try {
        const response = await fetch(`/api/v1/teachers/${user_id}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                Authorization: `Bearer ${token}`,
            },
        });
        const res = await response.json();
        teacherData = res.data || res;
        updateUI(teacherData);
    } catch (e) {
        console.error(e);
    }
}

function updateUI(teacher) {
    const user = teacher.user;
    if (!user) return;

    const fallback = "Non déterminé";

    document.getElementById("user-fullname").textContent =
        user.prenom && user.nom
            ? `${user.prenom} ${user.nom}`
            : "Utilisateur Inconnu";

    const birthInfo = document.getElementById("user-birth-info");
    birthInfo.textContent = user.birthday
        ? new Date(user.birthday).toLocaleDateString("fr-FR")
        : fallback;
    birthInfo.classList.toggle("opacity-50", !user.birthday);
    birthInfo.classList.toggle("italic", !user.birthday);
    birthInfo.classList.toggle("font-medium", !user.birthday);

    const genderEl = document.getElementById("user-gender");
    genderEl.textContent = user.gender
        ? user.gender === "M"
            ? "Masculin"
            : "Féminin"
        : fallback;
    genderEl.classList.toggle("opacity-50", !user.gender);
    genderEl.classList.toggle("italic", !user.gender);
    genderEl.classList.toggle("font-medium", !user.gender);

    const fields = {
        "user-phone": user.tel,
        "user-address": user.adress,
        "user-email": user.email,
    };

    Object.entries(fields).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (value) {
            el.textContent = value;
            el.classList.remove("opacity-50", "italic", "font-medium");
        } else {
            el.textContent = fallback;
            el.classList.add("opacity-50", "italic", "font-medium");
        }
    });

    document.getElementById("user-joined").textContent = user.created_at
        ? new Date(user.created_at).toLocaleDateString("fr-FR")
        : fallback;

    document.getElementById("user-avatar").src = user.photo
        ? `/storage/${user.photo}`
        : `/images/default.jpeg`;
}

function showFeedback(message, type) {
    const el = document.getElementById("save-feedback");
    el.textContent = message;
    el.classList.remove(
        "hidden",
        "bg-emerald-500/10",
        "border-emerald-500/30",
        "text-emerald-400",
        "bg-red-500/10",
        "border-red-500/30",
        "text-red-400",
    );
    el.classList.add("border");
    if (type === "success") {
        el.classList.add(
            "bg-emerald-500/10",
            "border-emerald-500/30",
            "text-emerald-400",
        );
    } else {
        el.classList.add("bg-red-500/10", "border-red-500/30", "text-red-400");
    }
    el.classList.remove("hidden");
    if (type === "success") setTimeout(() => hideFeedback(), 4000);
}

function hideFeedback() {
    document.getElementById("save-feedback").classList.add("hidden");
}
