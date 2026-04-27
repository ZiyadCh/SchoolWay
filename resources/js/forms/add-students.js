const dropzone = document.getElementById("dropzone");
const fileInput = document.getElementById("excelFile");

dropzone.addEventListener("click", () => fileInput.click());

fileInput.addEventListener("change", async (e) => {
    if (e.target.files.length > 0) {
        const formData = new FormData();
        formData.append("file", e.target.files[0]);
        formData.append("_token", "{{ csrf_token() }}");

        dropzone.querySelector("p.font-bold").innerText = "Envoi du fichier...";

        try {
            const response = await fetch("{{ route('students.import') }}", {
                method: "POST",
                body: formData,
            });

            if (response.ok) {
                alert("Importation réussie !");
                window.location.reload();
            } else {
                throw new Error("Erreur lors de l'import");
            }
        } catch (err) {
            alert(err.message);
            dropzone.querySelector("p.font-bold").innerText =
                "Cliquez ou glissez votre fichier Excel ici";
        }
    }
});

// --- VALIDATION ET ENVOI DU FORMULAIRE ---
const form = document.getElementById("studentForm");
const errorBox = document.getElementById("formErrors");
const submitBtn = document.getElementById("submitBtn");
const btnText = document.getElementById("btnText");
const btnIcon = document.getElementById("btnIcon");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    // Reset UI
    errorBox.classList.add("hidden");
    errorBox.innerHTML = "";
    submitBtn.disabled = true;
    btnText.innerText = "Traitement...";
    btnIcon.className = "fa-solid fa-circle-notch fa-spin text-lg";

    const formData = new FormData(form);

    try {
        const response = await fetch("{{ route('students.store') }}", {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
            body: formData,
        });

        const data = await response.json();

        if (!response.ok) {
            if (response.status === 422) {
                // Validation Laravel
                errorBox.classList.remove("hidden");
                const ul = document.createElement("ul");
                Object.values(data.errors).forEach((err) => {
                    const li = document.createElement("li");
                    li.innerText = "• " + err[0];
                    ul.appendChild(li);
                });
                errorBox.appendChild(ul);
            } else {
                throw new Error("Une erreur serveur est survenue.");
            }
        } else {
            // Succès : Redirection avec refresh comme demandé précédemment
            if (document.referrer) {
                window.location.href = document.referrer;
            } else {
                window.location.reload();
            }
        }
    } catch (err) {
        errorBox.classList.remove("hidden");
        errorBox.innerText = err.message;
    } finally {
        submitBtn.disabled = false;
        btnText.innerText = "Enregistrer l'élève";
        btnIcon.className = "fa-solid fa-plus text-lg";
    }
});
