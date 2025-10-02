// Module positions storage (in-memory, no localStorage)
let modulePositions = {};

// Initialize drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeDragAndDrop();
    initializeSearch();
    initializeFilters();
    initializeTooltips();
    loadModulePositions();
});

// Drag and Drop Implementation
function initializeDragAndDrop() {
    const modulesGrid = document.getElementById('modulesGrid');
    const moduleWidgets = document.querySelectorAll('.module-widget');
    
    let draggedElement = null;
    
    moduleWidgets.forEach(widget => {
        // Drag start
        widget.addEventListener('dragstart', function(e) {
            draggedElement = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        });
        
        // Drag end
        widget.addEventListener('dragend', function(e) {
            this.classList.remove('dragging');
            saveModulePositions();
        });
        
        // Drag over
        widget.addEventListener('dragover', function(e) {
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

// Save module positions to memory
function saveModulePositions() {
    const widgets = document.querySelectorAll('.module-widget');
    const positions = {};
    
    widgets.forEach((widget, index) => {
        const moduleId = widget.dataset.moduleId;
        positions[moduleId] = index;
    });
    
    modulePositions = positions;
    console.log('Module positions saved:', modulePositions);
}

// Load module positions from memory
function loadModulePositions() {
    if (Object.keys(modulePositions).length === 0) {
        return;
    }
    
    const modulesGrid = document.getElementById('modulesGrid');
    const widgets = Array.from(document.querySelectorAll('.module-widget'));
    
    // Sort widgets based on saved positions
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

// Search functionality
function initializeSearch() {
    const searchInput = document.getElementById('moduleSearch');
    
    searchInput.addEventListener('input', function() {
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

// Filter functionality
function initializeFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            const widgets = document.querySelectorAll('.module-widget');
            
            widgets.forEach(widget => {
                const status = widget.dataset.status;
                
                if (filter === 'all') {
                    widget.classList.remove('hidden');
                } else if (filter === status) {
                    widget.classList.remove('hidden');
                } else {
                    widget.classList.add('hidden');
                }
            });
        });
    });
}

// Initialize Bootstrap tooltips
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Form submission with loading state
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.module-toggle-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('.toggle-btn');
            const icon = button.querySelector('i');
            
            // Add loading state
            button.disabled = true;
            icon.className = 'bi bi-hourglass-split';
            
            // Note: Form will submit normally, this is just for visual feedback
        });
    });
});

// Smooth animations on scroll
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