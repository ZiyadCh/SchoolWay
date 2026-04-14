function updatePagination(result, fetchStudents) {
    const container = document.getElementById("page-numbers");
    container.innerHTML = "";

    const current = result.current_page;
    const last = result.last_page;

    let start = Math.max(1, current - 1);
    let end = Math.min(last, current + 1);

    if (last <= 3) {
        start = 1;
        end = last;
    }

    for (let i = start; i <= end; i++) {
        const active = i === current;
        const button = document.createElement("button");

        button.textContent = i;

        button.className = `w-10 h-10 flex items-center justify-center rounded-xl text-xs border ${
            active
                ? "bg-amber-500 text-black border-amber-500 shadow-lg"
                : "bg-gray-800 text-gray-400 border-gray-700"
        }`;

        if (active) button.disabled = true;

        container.appendChild(button);
    }
}

export default updatePagination;
