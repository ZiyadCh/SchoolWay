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
        } catch (error) {
            console.error("Erreur réseau lors de la déconnexion :", error);
        } finally {
            localStorage.clear();

            window.location.href = "/login";
        }
    });
});

// when the user enters a page of another role
export function unauthorizedPage() {
    localStorage.clear();
    sessionStorage.clear();

    window.location.href = "/login";
}
export default unauthorizedPage;
