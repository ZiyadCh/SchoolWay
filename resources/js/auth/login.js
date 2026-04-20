document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    //errors labels
    const errorAlert = document.getElementById("errorAlert");
    const errorMessage = document.getElementById("errorMessage");

    errorAlert.classList.add("hidden");
    errorMessage.innerHTML = "";

    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    try {
        const response = await fetch("/api/v1/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                    .value,
            },
            body: JSON.stringify(data),
            credentials: "include",
        });

        const result = await response.json();

        if (response.ok) {
            localStorage.setItem("token", result.access_token);
            localStorage.setItem("user", JSON.stringify(result.user));

            if (result.user.role === "admin") {
                window.location.href = "/administration/dashboard";
            } else {
                window.location.href = "/student/profile";
            }
            //gestion erreur
        } else {
            errorAlert.classList.remove("hidden");

            if (response.status === 422 && result.errors) {
                const allErrors = Object.values(result.errors).flat();
                errorMessage.innerHTML = allErrors.join("<br>");
            } else {
                errorMessage.textContent =
                    result.message || "Erreur l\'ors de l'inscription";
            }
        }
    } catch (error) {
        console.error("Error:", error);
        errorAlert.classList.remove("hidden");
        errorMessage.textContent = "Une erreur de connexion est survenue.";
    }
});
