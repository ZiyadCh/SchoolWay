document.addEventListener("DOMContentLoaded", () => {
    const teacherForm = document.getElementById("teacherForm");
    const imageInput = document.getElementById("teacherImage");
    const previewImg = document.getElementById("previewImg");
    const previewIcon = document.querySelector("#imagePreview i.fa-camera");

    if (imageInput) {
        imageInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert("L'image est trop lourde (max 2Mo)");
                    this.value = "";
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove("hidden");
                    if (previewIcon) previewIcon.classList.add("hidden");
                };
                reader.readAsDataURL(file);
            }
        });
    }

    teacherForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const submitBtn = document.getElementById("submitBtn");
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>Enregistrement...</span>`;

        try {
            const formData = new FormData(teacherForm);

            const res = await fetch("/api/v1/teachers", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN":
                        teacherForm.querySelector('[name="_token"]').value,
                },
                body: formData,
            });

            if (res.ok) {
                teacherForm.reset();

                if (previewImg) {
                    previewImg.src = "";
                    previewImg.classList.add("hidden");
                }
                if (previewIcon) previewIcon.classList.remove("hidden");

                alert("Enseignant enregistré avec succès !");
            } else {
                const errorData = await res.json();
                alert(
                    errorData.message ||
                        "Une erreur est survenue lors de l'enregistrement",
                );
            }
        } catch (err) {
            console.error(err);
            alert("Erreur de connexion au serveur");
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });
});
