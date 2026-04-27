document.addEventListener("DOMContentLoaded", () => {
    const teacherForm = document.getElementById("teacherForm");
    const submitBtn = document.getElementById("submitBtn");

    teacherForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        // État de chargement
        const originalContent = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>Enregistrement...</span>`;

        try {
            const res = await fetch("/api/v1/teachers", {
                // Ajuste l'URL selon tes routes
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN":
                        teacherForm.querySelector('[name="_token"]').value,
                },
                body: new FormData(teacherForm),
            });

            if (res.ok) {
                teacherForm.reset();
                alert("Enseignant enregistré avec succès !");
            } else {
                const data = await res.json();
                alert(data.message || "Erreur lors de l'enregistrement");
            }
        } catch (err) {
            console.error(err);
            alert("Erreur de connexion au serveur");
        } finally {
            // Restaurer le bouton
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalContent;
        }
    });
});
