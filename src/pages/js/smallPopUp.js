function showDynamicModal(command, title = '', history) {
    // del les anciens modals
    const oldModal = document.getElementById("dynamicBootstrapModal");
    if (oldModal) {
        oldModal.remove();
    }

    // Crée le modal avec le html bootstrap
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
                <div class="module-history mt-3">
                    <span class="history-text text-secondary">History output:</span>
                    <pre class="history-pre bg-dark text-light p-3 rounded" style="max-height: 400px; overflow-y: auto;">${history}</pre>
                </div>
              </div>
            </div>
          </div>
        </div>
    `;

    document.body.appendChild(modalWrapper);

    const modalEl = document.getElementById("dynamicBootstrapModal");
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
}
