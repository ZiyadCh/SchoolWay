document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    delete data._token;

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
            } else if (result.user.role === "student") {
                window.location.href = "/student/profile";
            }
        }
    } catch (error) {
        console.error("Error:", error);
    }
});
