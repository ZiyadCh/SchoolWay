document.addEventListener("DOMContentLoaded", () => {
    const logoutBtn = document.getElementById("logoutBtn");

    logoutBtn.addEventListener("click", async (e) => {
        e.preventDefault();

        const token = localStorage.getItem("token");

        logoutBtn.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin"></i> Déconnexion...';
        logoutBtn.disabled = true;

        try {
            const response = await fetch("/api/v1/logout", {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
            });

            if (!response.ok) {
                console.warn(
                    "Le serveur n'a pas pu invalider le token, mais on déconnecte quand même localement.",
                );
            }
        } catch (error) {
            console.error("Erreur réseau lors de la déconnexion :", error);
        } finally {
            localStorage.clear();

            window.location.href = "/login";
        }
    });
});
