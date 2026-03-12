function switchTab(event, tabId) {
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-amber-500', 'text-black', 'shadow-lg', 'shadow-amber-500/20');
            btn.classList.add('text-gray-500', 'hover:text-white');
        });

        event.currentTarget.classList.add('bg-amber-500', 'text-black', 'shadow-lg', 'shadow-amber-500/20');
        event.currentTarget.classList.remove('text-gray-500', 'hover:text-white');

        const contents = document.querySelectorAll('.tab-content');
        const target = document.getElementById(tabId);

        contents.forEach(content => {
            content.classList.add('opacity-0');
            setTimeout(() => {
                content.classList.add('hidden');
                if (content.id === tabId) {
                    content.classList.remove('hidden');
                    setTimeout(() => content.classList.remove('opacity-0'), 10);
                }
            }, 150);
        });
    }
