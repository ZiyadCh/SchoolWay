export function renderStudents(inscriptions, containerId = "students-list") {
    const container = document.getElementById(containerId);
    if (!container) return;

    container.innerHTML = "";

    if (!inscriptions || inscriptions.length === 0) {
        container.innerHTML = `<tr><td colspan="2" class="p-12 text-center text-gray-600 text-[10px] font-black uppercase tracking-widest">Aucune inscription</td></tr>`;
        return;
    }

    inscriptions.forEach((ins) => {
        const student = ins.student?.user || {};
        const tr = document.createElement("tr");
        tr.className =
            "border-b border-gray-800/50 hover:bg-gray-800/10 transition-all group";
        tr.innerHTML = `
            <td class="px-8 py-5">
                <div class="flex items-center gap-4">
                    <img src="${student.photo ? "/storage/" + student.photo : "/images/default.jpeg"}" class="w-10 h-10 rounded-xl object-cover grayscale group-hover:grayscale-0 transition-all border border-gray-800">
                    <span class="text-sm font-bold text-gray-300 group-hover:text-amber-500 transition-colors uppercase">${student.prenom || ""} ${student.nom || ""}</span>
                </div>
            </td>
            <td class="px-8 py-5 text-right">
                <a href="/students/inspect/${ins.id}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-800 text-gray-500 hover:bg-amber-500 hover:text-black transition-all">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            </td>
        `;
        container.appendChild(tr);
    });
}
