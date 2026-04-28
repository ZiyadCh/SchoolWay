document.addEventListener("DOMContentLoaded", () => {
    const classForm = document.getElementById("classForm");
    const submitBtn = document.getElementById("submitBtn");
    const levelSelect = document.querySelector('select[name="level_id"]');
    const subjectSelect = document.querySelector('select[name="subject_id"]');

    const teacherSearch = document.getElementById("teacherSearch");
    const teacherResults = document.getElementById("teacherResults");
    const selectedTeacherId = document.getElementById("selectedTeacherId");

    const appendOption = (select, text, value) => {
        const opt = new Option(text, value);
        select.add(opt);
    };

    const initData = async () => {
        try {
            const [levelsRes, subjectsRes] = await Promise.all([
                fetch("/api/v1/levels"),
                fetch("/api/v1/subjects"),
            ]);

            const levels = await levelsRes.json();
            const subjects = await subjectsRes.json();

            if (levels.data) {
                levels.data.forEach((l) =>
                    appendOption(levelSelect, l.name, l.id),
                );
            }

            if (subjects.data) {
                subjects.data.forEach((s) =>
                    appendOption(subjectSelect, s.name, s.id),
                );
            }
        } catch (e) {
            console.error(e);
        }
    };

    let debounceTimer;
    teacherSearch.addEventListener("input", (e) => {
        clearTimeout(debounceTimer);
        const query = e.target.value.trim();

        if (query.length < 2) {
            teacherResults.classList.add("hidden");
            teacherResults.replaceChildren();
            selectedTeacherId.value = "";
            return;
        }

        debounceTimer = setTimeout(async () => {
            try {
                const res = await fetch(
                    `/api/v1/teachers?search=${encodeURIComponent(query)}`,
                );
                const json = await res.json();

                teacherResults.replaceChildren();

                if (json.data && json.data.length > 0) {
                    json.data.forEach((t) => {
                        const name = t.user
                            ? `${t.user.nom} ${t.user.prenom}`
                            : `ID: ${t.id}`;

                        const item = document.createElement("div");
                        item.className =
                            "px-6 py-3 hover:bg-indigo-600 cursor-pointer transition-colors border-b border-gray-800 last:border-0";
                        item.textContent = name;

                        item.addEventListener("click", () => {
                            teacherSearch.value = name;
                            selectedTeacherId.value = t.id;
                            teacherResults.classList.add("hidden");
                        });

                        teacherResults.appendChild(item);
                    });
                    teacherResults.classList.remove("hidden");
                } else {
                    const noResult = document.createElement("div");
                    noResult.className = "px-6 py-3 text-gray-500 text-sm";
                    noResult.textContent = "Aucun résultat";
                    teacherResults.appendChild(noResult);
                    teacherResults.classList.remove("hidden");
                }
            } catch (err) {
                console.error(err);
            }
        }, 300);
    });

    classForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        if (!selectedTeacherId.value) {
            alert("Veuillez sélectionner un enseignant valide.");
            return;
        }

        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = "Action en cours...";

        try {
            const res = await fetch("/api/v1/school_classes", {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'input[name="_token"]',
                    ).value,
                },
                body: new FormData(classForm),
            });

            if (res.ok) {
                classForm.reset();
                selectedTeacherId.value = "";
                alert("Classe créée avec succès !");
            } else {
                const errData = await res.json();
                alert(errData.message || "Erreur de validation");
            }
        } catch (err) {
            alert("Erreur réseau");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });

    document.addEventListener("click", (e) => {
        if (
            !teacherSearch.contains(e.target) &&
            !teacherResults.contains(e.target)
        ) {
            teacherResults.classList.add("hidden");
        }
    });

    initData();
});
