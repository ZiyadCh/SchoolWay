document.addEventListener("DOMContentLoaded", () => {
    const studentForm = document.getElementById("studentForm");
    const excelForm = document.getElementById("excelForm");
    const excelAlert = document.getElementById("excelAlert");
    const importBtn = document.getElementById("importBtn");
    const fileInput = document.getElementById("excelFile");
    const dropzoneText = document.getElementById("dropzoneText");

    // --- FORMULAIRE MANUEL ---
    studentForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        try {
            const res = await fetch("/api/v1/students", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN":
                        studentForm.querySelector('[name="_token"]').value,
                },
                body: new FormData(studentForm),
            });

            if (res.ok) {
                studentForm.reset();
                alert("Utilisateur enregistré avec succès");
            } else {
                alert("Une erreur est survenue lors de l'enregistrement");
            }
        } catch (err) {
            console.error(err);
        }
    });

    // --- IMPORTATION EXCEL ---
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

    document
        .getElementById("dropzone")
        .addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", () => {
        if (fileInput.files.length) {
            dropzoneText.textContent = fileInput.files[0].name;
            importBtn.disabled = false;
        }
    });
});
