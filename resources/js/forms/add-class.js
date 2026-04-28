document.addEventListener("DOMContentLoaded", () => {
    console.log("gg");
    const classForm = document.getElementById("classForm");
    const submitBtn = document.getElementById("submitBtn");

    const levelSelect = document.querySelector('select[name="level_id"]');
    const subjectSelect = document.querySelector('select[name="subject_id"]');
    const teacherSelect = document.querySelector('select[name="teacher_id"]');

    const loadOptions = async () => {
        try {
            console.log("Tentative de récupération des données...");

            const [levelsRes, subjectsRes, teachersRes] = await Promise.all([
                fetch("/api/v1/levels"),
                fetch("/api/v1/subjects"),
                fetch("/api/v1/teachers"),
            ]);

            if (!levelsRes.ok || !subjectsRes.ok || !teachersRes.ok) {
                throw new Error(
                    `Erreur HTTP! Statuts: ${levelsRes.status}, ${subjectsRes.status}, ${teachersRes.status}`,
                );
            }

            const levelsJson = await levelsRes.json();
            const subjectsJson = await subjectsRes.json();
            const teachersJson = await teachersRes.json();

            if (levelsJson.data) {
                levelSelect.innerHTML =
                    '<option value="" disabled selected>Choisir un niveau</option>';
                levelsJson.data.forEach((level) => {
                    levelSelect.innerHTML += `<option value="${level.id}">${level.name}</option>`;
                });
            }

            if (subjectsJson.data) {
                subjectSelect.innerHTML =
                    '<option value="" disabled selected>Choisir une matière</option>';
                subjectsJson.data.forEach((subject) => {
                    subjectSelect.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                });
            }

            if (teachersJson.data) {
                teacherSelect.innerHTML =
                    '<option value="" disabled selected>Sélectionner un enseignant</option>';
                teachersJson.data.forEach((teacher) => {
                    const displayName = `Enseignant #${teacher.id} (User ID: ${teacher.user_id})`;
                    teacherSelect.innerHTML += `<option value="${teacher.id}">${displayName}</option>`;
                });
            }
        } catch (err) {
            console.error("ERREUR CRITIQUE DANS loadOptions :", err);
        }
    };
    loadOptions();

    classForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const originalBtnContent = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>Création...</span>`;

        try {
            const res = await fetch("/api/v1/school-classes", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN":
                        classForm.querySelector('[name="_token"]').value,
                },
                body: new FormData(classForm),
            });

            if (res.ok) {
                classForm.reset();
                alert("Classe créée avec succès !");
            } else {
                alert("Une erreur est survenue lors de la création.");
            }
        } catch (err) {
            console.error(err);
            alert("Erreur de connexion");
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnContent;
        }
    });
});
