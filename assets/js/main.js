// Pegasus Doxing JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Add any client-side functionality here
    
    // Example: Add loading state to form submission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Searching...';
                submitButton.disabled = true;
            }
        });
    }
    
    // Example: Add select all modules functionality
    const selectAllCheckbox = document.createElement('div');
    selectAllCheckbox.className = 'form-check mb-3';
    selectAllCheckbox.innerHTML = `
        <input class="form-check-input" type="checkbox" id="selectAllModules">
        <label class="form-check-label" for="selectAllModules">Select All Modules</label>
    `;
    
    const modulesContainer = document.querySelector('.form-label').parentElement;
    if (modulesContainer) {
        modulesContainer.insertBefore(selectAllCheckbox, modulesContainer.firstChild);
        
        const selectAll = document.getElementById('selectAllModules');
        const moduleCheckboxes = document.querySelectorAll('input[name="modules[]"]');
        
        selectAll.addEventListener('change', function() {
            moduleCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
}); 