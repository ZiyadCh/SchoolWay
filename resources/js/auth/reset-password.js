document.addEventListener("DOMContentLoaded", function () {
    const token = localStorage.getItem("token");
    const modal = document.getElementById("reset-modal");
    const openBtn = document.getElementById("open-reset-modal");
    const closeBtn = document.getElementById("close-reset-modal");
    const submitBtn = document.getElementById("submit-reset");
    const message = document.getElementById("reset-message");

    openBtn.addEventListener("click", () => {
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    });

    closeBtn.addEventListener("click", closeModal);

    modal.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    function closeModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        document.getElementById("new-password").value = "";
        document.getElementById("new-password-confirmation").value = "";
        message.classList.add("hidden");
        message.textContent = "";
    }

    submitBtn.addEventListener("click", async () => {
        const new_password = document
            .getElementById("new-password")
            .value.trim();
        const new_password_confirmation = document
            .getElementById("new-password-confirmation")
            .value.trim();

        if (!new_password || !new_password_confirmation) {
            showMessage("Veuillez remplir tous les champs.", "text-red-400");
            return;
        }

        if (new_password !== new_password_confirmation) {
            showMessage(
                "Les mots de passe ne correspondent pas.",
                "text-red-400",
            );
            return;
        }

        if (new_password.length < 8) {
            showMessage(
                "Le mot de passe doit contenir au moins 8 caractères.",
                "text-red-400",
            );
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = "Traitement...";

        try {
            const response = await fetch("/api/v1/reset-password", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    new_password,
                    new_password_confirmation,
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                showMessage(
                    result.message || "Une erreur est survenue.",
                    "text-red-400",
                );
            } else {
                showMessage(result.message, "text-emerald-400");
                setTimeout(closeModal, 2000);
            }
        } catch (error) {
            showMessage("Erreur de connexion.", "text-red-400");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = "Confirmer";
        }
    });

    function showMessage(text, colorClass) {
        message.textContent = text;
        message.className = `text-[11px] font-bold text-center ${colorClass}`;
        message.classList.remove("hidden");
    }
});
