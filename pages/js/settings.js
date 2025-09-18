document.addEventListener('DOMContentLoaded', function () {
    // Password confirmation validation
    const passwordForm = document.getElementById('passwordForm');
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');

    function validatePasswords() {
        if (newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Les mots de passe ne correspondent pas');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    newPassword.addEventListener('input', validatePasswords);
    confirmPassword.addEventListener('input', validatePasswords);

    // Form submission with loading states
    passwordForm.addEventListener('submit', function (e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Modification...';
    });

    const profileForm = document.getElementById('profileForm');
    profileForm.addEventListener('submit', function (e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Mise à jour...';
    });
});

function generateNewToken() {
    if (confirm('Êtes-vous sûr de vouloir générer un nouveau token API ? L\'ancien token ne fonctionnera plus.')) {
        // Implement token generation via AJAX if needed
        alert('Fonctionnalité de génération de token à implémenter');
    }
}
function getCitation() {
    fetch('https://api.adolf.rest', { mode: 'cors' })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.getElementById('citation').textContent = `"${data.quote}"`;
        })
        .catch(error => {
            fetch('https://api.kanye.rest/')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('citation').textContent = `"${data.quote}"`;
                })
                .catch(error => {
                    console.error('Error fetching citation:', error);
                    document.getElementById('citation').textContent = 'Impossible de récupérer une citation pour le moment.';
                });
        });
}
getCitation();