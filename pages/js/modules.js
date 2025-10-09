// La ou on va stocker les positions des modules (on va les saves après)
let modulePositions = {};

// On fait l'initialisation de toutes les fonctionnalités une fois le DOM chargé
document.addEventListener('DOMContentLoaded', function () {
    initializeDragAndDrop();
    initializeSearch();
    initializeFilters();
    initializeTooltips();
    loadModulePositions();
});

// Drag and Drop
function initializeDragAndDrop() {
    const modulesGrid = document.getElementById('modulesGrid');
    const moduleWidgets = document.querySelectorAll('.module-widget');

    let draggedElement = null;

    moduleWidgets.forEach(widget => {
        // Drag start
        widget.addEventListener('dragstart', function (e) {
            draggedElement = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        });

        // Drag end
        widget.addEventListener('dragend', function (e) {
            this.classList.remove('dragging');
            saveModulePositions();
        });

        // Drag over
        widget.addEventListener('dragover', function (e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';

            if (this !== draggedElement) {
                const rect = this.getBoundingClientRect();
                const midpoint = rect.left + rect.width / 2;

                if (e.clientX < midpoint) {
                    this.parentNode.insertBefore(draggedElement, this);
                } else {
                    this.parentNode.insertBefore(draggedElement, this.nextSibling);
                }
            }
        });
    });
}

// Sauvegarde des modules positions
function saveModulePositions() {
    const widgets = document.querySelectorAll('.module-widget');
    const positions = {};

    widgets.forEach((widget, index) => {
        const moduleId = widget.dataset.moduleId;
        positions[moduleId] = index;
    });

    modulePositions = positions;
    localStorage.setItem('modulePositions', JSON.stringify(modulePositions)); // Sauvegarde dans le localstorage
    console.log('Module positions saved:', modulePositions);
}

// load des modules positions
function loadModulePositions() {
    const savedPositions = localStorage.getItem('modulePositions');
    if (savedPositions) {
        modulePositions = JSON.parse(savedPositions); // Récupération dans le localstorage
        console.log('Module positions loaded:', modulePositions);
    }

    if (Object.keys(modulePositions).length === 0) {
        return;
    }

    const modulesGrid = document.getElementById('modulesGrid');
    const widgets = Array.from(document.querySelectorAll('.module-widget'));

    // On trie les widgets selon les positions sauvegardées (chatgpt m'a aidé pour cette partie)
    widgets.sort((a, b) => {
        const posA = modulePositions[a.dataset.moduleId] ?? 999;
        const posB = modulePositions[b.dataset.moduleId] ?? 999;
        return posA - posB;
    });

    // Reorder in DOM
    widgets.forEach(widget => {
        modulesGrid.appendChild(widget);
    });
}


// Search
function initializeSearch() {
    const searchInput = document.getElementById('moduleSearch');
    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const widgets = document.querySelectorAll('.module-widget');

        widgets.forEach(widget => {
            const title = widget.querySelector('.module-title').textContent.toLowerCase();
            const description = widget.querySelector('.module-description').textContent.toLowerCase();

            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                widget.classList.remove('hidden');
            } else {
                widget.classList.add('hidden');
            }
        });
    });
}

// Filte
function initializeFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const deviceFilter = document.getElementById('deviceSelect'); 

    if (filterButtons.length) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function () {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                const widgets = document.querySelectorAll('.module-widget');

                widgets.forEach(widget => {
                    const status = widget.dataset.status;
                    if (filter === 'all' || filter === status) {
                        widget.classList.remove('hidden');
                    } else {
                        widget.classList.add('hidden');
                    }
                });

                // Reset le dropdown si on clique sur le bouton
                if (deviceFilter) deviceFilter.value = "all";
            });
        });
    }

    if (deviceFilter) {
        deviceFilter.addEventListener('change', function () {
            const filter = this.value;
            const widgets = document.querySelectorAll('.module-widget');

            filterButtons.forEach(btn => btn.classList.remove('active'));

            widgets.forEach(widget => {
                const device = widget.dataset.device; 
                if (filter === 'all' || filter === device) {
                    widget.classList.remove('hidden');
                } else {
                    widget.classList.add('hidden');
                }
            });
        });
    }
}

// Init search et filter
document.addEventListener('DOMContentLoaded', () => {
    initializeSearch();
    initializeFilters();
});

// Application des tooltips bootstrap
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Animation horloge quand on click sur un button (agis comme form submit)
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.module-toggle-form');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const button = this.querySelector('.toggle-btn');
            const icon = button.querySelector('i');

            button.disabled = true;
            icon.className = 'bi bi-hourglass-split';
            // C'est uniquement visuelle la requete par quand même
        });
    });
});

// Animation fade in des modules quand on scroll (chatgpt m'a aidé pour cette partie)
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'widgetFadeIn 0.5s ease-out forwards';
        }
    });
}, {
    threshold: 0.1
});

document.querySelectorAll('.module-widget').forEach(widget => {
    observer.observe(widget);
});

// Pour afficher le modal sans utiliser les popup en php parce que c'est moche
document.querySelectorAll('#readCommand').forEach(element => {
    element.addEventListener('click', function () {
        showDynamicModal(element.dataset.command, 'Module Command (' + element.dataset.title + ')' ,atob(element.dataset.history));
    });
}); 