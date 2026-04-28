document.addEventListener("DOMContentLoaded", () => {
    const studentForm = document.getElementById("studentForm");
    const excelForm = document.getElementById("excelForm");
    const excelAlert = document.getElementById("excelAlert");
    const importBtn = document.getElementById("importBtn");
    const fileInput = document.getElementById("excelFile");
    const dropzoneText = document.getElementById("dropzoneText");

    const imageInput = document.getElementById("studentImage");
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

    studentForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const submitBtn = document.getElementById("submitBtn");
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;

        try {
            const formData = new FormData(studentForm);

            const res = await fetch("/api/v1/students", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN":
                        studentForm.querySelector('[name="_token"]').value,
                },
                body: formData,
            });

            if (res.ok) {
                studentForm.reset();
                if (previewImg) {
                    previewImg.src = "";
                    previewImg.classList.add("hidden");
                }
                if (previewIcon) previewIcon.classList.remove("hidden");
                alert("Utilisateur enregistré avec succès");
            } else {
                const errorData = await res.json();
                alert(errorData.message || "Une erreur est survenue");
            }
        } catch (err) {
            console.error(err);
            alert("Erreur de connexion au serveur");
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });

    excelForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const originalBtnContent = importBtn.innerHTML;
        importBtn.disabled = true;
        importBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>Importation en cours...</span>`;

        const fd = new FormData();
        fd.append("file", fileInput.files[0]);

        try {
            const res = await fetch("/api/v1/students", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN":
                        excelForm.querySelector('[name="_token"]').value,
                },
                body: fd,
            });

            if (res.ok) {
                excelAlert.className =
                    "px-6 py-4 rounded-2xl text-sm font-bold border border-green-500 text-green-400";
                excelAlert.textContent = "Importation réussie";
                excelAlert.classList.remove("hidden");
                excelForm.reset();
                dropzoneText.textContent =
                    "Cliquez ou glissez votre fichier Excel ici";
                importBtn.innerHTML = originalBtnContent;
                importBtn.disabled = true;
            } else {
                excelAlert.className =
                    "px-6 py-4 rounded-2xl text-sm font-bold border border-red-500 text-red-400";
                excelAlert.textContent = "Erreur lors de l'importation";
                excelAlert.classList.remove("hidden");
                importBtn.innerHTML = originalBtnContent;
                importBtn.disabled = false;
            }
        } catch (err) {
            console.error(err);
            excelAlert.className =
                "px-6 py-4 rounded-2xl text-sm font-bold border border-red-500 text-red-400";
            excelAlert.textContent = "Erreur de connexion";
            excelAlert.classList.remove("hidden");
            importBtn.innerHTML = originalBtnContent;
            importBtn.disabled = false;
        }
    });

    const dropzone = document.getElementById("dropzone");
    if (dropzone) {
        dropzone.addEventListener("click", () => fileInput.click());
    }

    fileInput.addEventListener("change", () => {
        if (fileInput.files.length) {
            dropzoneText.textContent = fileInput.files[0].name;
            importBtn.disabled = false;
        }
    });
});
