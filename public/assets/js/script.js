document.addEventListener('DOMContentLoaded', () => {

    // --- 1. Animation d'apparition des cartes ---
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100); // Délai progressif
    });

    // --- 2. Recherche Live (Filtrage) ---
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const taskCards = document.querySelectorAll('.tasks-grid .card');

            taskCards.forEach(card => {
                const title = card.querySelector('h3').innerText.toLowerCase();
                const desc = card.querySelector('p').innerText.toLowerCase();
                
                if (title.includes(searchTerm) || desc.includes(searchTerm)) {
                    card.style.display = 'flex';
                    // Ré-animer l'apparition
                    card.style.opacity = '1'; 
                    card.style.transform = 'translateY(0)';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // --- 3. Auto-Dismiss Alerts ---
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000); // Disparait après 3 secondes
    }

    // --- 4. Hover Effects (si non géré en CSS) ---
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
            card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = 'none'; // Ou remettre l'ombre par défaut si nécessaire
        });
    });
    // --- 5. Sidebar Toggle Functionality (Unified) ---
    const sidebar = document.getElementById('sidebar');
    const toggles = document.querySelectorAll('.sidebar-toggle, .sidebar-toggle-btn');
    
    if (sidebar && toggles.length > 0) {
        // Check for saved state
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
        }

        toggles.forEach(btn => {
            btn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                const collapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', collapsed);
            });
        });
    }

    // --- 6. Table Sorting (Client-side) ---
    const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;
    const comparer = (idx, asc) => (a, b) => ((v1, v2) => 
        v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
        )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

    document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
        const table = th.closest('table');
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        Array.from(tbody.querySelectorAll('tr'))
            .sort(comparer(Array.from(th.parentNode.children).indexOf(th), th.asc = !th.asc))
            .forEach(tr => tbody.appendChild(tr) );
        
        // Visual indicator
        th.closest('tr').querySelectorAll('th').forEach(h => h.classList.remove('sort-asc', 'sort-desc'));
        th.classList.add(th.asc ? 'sort-asc' : 'sort-desc');
    })));

    // --- 7. Micro-Animations for Stat Cards ---
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            const icon = card.querySelector('.stat-icon');
            if (icon) icon.style.transform = 'scale(1.2) rotate(10deg)';
        });
        card.addEventListener('mouseleave', () => {
            const icon = card.querySelector('.stat-icon');
            if (icon) icon.style.transform = 'scale(1) rotate(0deg)';
        });
    });

    // --- 8. Scroll to Top Button ---
    const scrollBtn = document.createElement('button');
    scrollBtn.innerHTML = '↑';
    scrollBtn.className = 'scroll-to-top';
    document.body.appendChild(scrollBtn);

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollBtn.classList.add('visible');
        } else {
            scrollBtn.classList.remove('visible');
        }
    });

    scrollBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
