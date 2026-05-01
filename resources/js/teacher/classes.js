const token = localStorage.getItem("token");

document.addEventListener("DOMContentLoaded", () => {
    const user = JSON.parse(localStorage.getItem("user"));
    const teacherId = user.id;
    console.log(teacherId);
    fetchClasses(teacherId);
});

async function fetchClasses(teacherId) {
    const container = document.getElementById("classes-container");

    try {
        const response = await fetch(`/api/user/`, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });

        if (!response.ok) throw new Error("Erreur");

        const result = await response.json();
        const classes = result.data?.classes || [];

        if (classes.length === 0) {
            container.innerHTML = `<p class="text-gray-500 italic col-span-full">Aucune classe assignée.</p>`;
            return;
        }

        container.innerHTML = classes
            .map(
                (cls) => `
            <a href="/teacher/classes/${cls.id}" class="bg-gray-900 border border-gray-800 p-6 rounded-2xl hover:border-amber-500/50 transition-all duration-300 group block">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-[10px] bg-amber-500/10 text-amber-500 px-2 py-1 rounded font-black uppercase tracking-widest border border-amber-500/20">
                        ${cls.level ? cls.level.name : "Niveau N/A"}
                    </span>
                    <div class="p-2 bg-gray-800 rounded-lg group-hover:bg-amber-500/10 transition-colors">
                        <i class="ri-book-open-line text-gray-500 group-hover:text-amber-500"></i>
                    </div>
                </div>
                <h4 class="text-white font-bold text-lg uppercase tracking-tight">${cls.name}</h4>
                <div class="flex items-center gap-2 mt-3">
                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">${cls.nbr_students || 0} élèves</span>
                </div>
            </a>
        `,
            )
            .join("");
    } catch (error) {
        console.error(error);
        container.innerHTML = `<p class="text-red-500 col-span-full text-xs font-bold uppercase">Erreur de chargement.</p>`;
    }
}
