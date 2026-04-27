document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("studentForm");
    const submitBtn = document.getElementById("submitBtn");
    const alertBox = document.getElementById("formAlert");

    const dropzone = document.getElementById("dropzone");
    const fileInput = document.getElementById("excelFile");
    const dropzoneText = document.getElementById("dropzoneText");

    function showAlert(message, type = "success") {
        alertBox.classList.remove(
            "hidden",
            "border-red-500",
            "border-green-500",
        );

        if (type === "error") {
            alertBox.classList.add("border-red-500", "text-red-400");
        } else {
            alertBox.classList.add("border-green-500", "text-green-400");
        }

        alertBox.innerText = message;
    }

    function resetAlert() {
        alertBox.classList.add("hidden");
        alertBox.innerText = "";
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        resetAlert();

        submitBtn.disabled = true;
        submitBtn.innerHTML = "Enregistrement...";

        const formData = new FormData(form);

        try {
            const res = await fetch("/students", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'input[name="_token"]',
                    ).value,
                },
                body: formData,
            });

            const data = await res.json();

            if (!res.ok) {
                throw data;
            }

            showAlert("Étudiant ajouté avec succès !");
            form.reset();
        } catch (err) {
            console.error(err);

            if (err.errors) {
                // Laravel validation errors
                const firstError = Object.values(err.errors)[0][0];
                showAlert(firstError, "error");
            } else {
                showAlert("Erreur lors de l'ajout.", "error");
            }
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<i class="fa-solid fa-plus text-lg"></i><span>Enregistrer l'élève</span>`;
        }
    });

    dropzone.addEventListener("click", () => fileInput.click());

    dropzone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropzone.classList.add("border-emerald-500");
    });

    dropzone.addEventListener("dragleave", () => {
        dropzone.classList.remove("border-emerald-500");
    });

    dropzone.addEventListener("drop", (e) => {
        e.preventDefault();
        dropzone.classList.remove("border-emerald-500");

        const file = e.dataTransfer.files[0];
        handleFile(file);
    });

    fileInput.addEventListener("change", () => {
        const file = fileInput.files[0];
        handleFile(file);
    });

    function handleFile(file) {
        if (!file) return;

        const allowedTypes = [
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.ms-excel",
            "text/csv",
        ];

        if (!allowedTypes.includes(file.type)) {
            showAlert("Format invalide. Utilisez un fichier Excel.", "error");
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            showAlert("Fichier trop volumineux (max 5MB).", "error");
            return;
        }

        dropzoneText.innerText = file.name;

        uploadExcel(file);
    }

    async function uploadExcel(file) {
        resetAlert();

        const formData = new FormData();
        formData.append("file", file);

        try {
            const res = await fetch("/students/import", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'input[name="_token"]',
                    ).value,
                },
                body: formData,
            });

            const data = await res.json();

            if (!res.ok) {
                throw data;
            }

            showAlert(data.message || "Importation réussie !");
            dropzoneText.innerText =
                "Cliquez ou glissez votre fichier Excel ici";
        } catch (err) {
            console.error(err);

            if (err.errors) {
                const firstError = Object.values(err.errors)[0][0];
                showAlert(firstError, "error");
            } else {
                showAlert("Erreur lors de l'importation.", "error");
            }
        }
    }
});
