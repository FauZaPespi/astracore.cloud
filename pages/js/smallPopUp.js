function showDynamicModal(command, title = '') {
    // Remove any old modal if exists
    const oldModal = document.getElementById("dynamicBootstrapModal");
    if (oldModal) {
        oldModal.remove();
    }

    // Create modal container dynamically
    const modalWrapper = document.createElement("div");
    modalWrapper.innerHTML = `
        <div class="modal fade" id="dynamicBootstrapModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">${title}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="module-command">
                    <span class="command-text text-secondary">Command:</span>
                    <code class="command-code">${command}</code>
                </div>
              </div>
            </div>
          </div>
        </div>
    `;

    // Append modal to body
    document.body.appendChild(modalWrapper);

    // Initialize and show Bootstrap modal
    const modalEl = document.getElementById("dynamicBootstrapModal");
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}
