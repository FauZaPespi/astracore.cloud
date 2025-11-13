<?php
require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/User.php";

global $user;

$message = '';
$messageType = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_profile':
                $newUsername = trim($_POST['username'] ?? '');
                $newEmail = trim($_POST['email'] ?? '');

                // Validation
                $errors = [];
                if (empty($newUsername)) {
                    $errors[] = "Le nom d'utilisateur ne peut pas être vide.";
                }
                if (empty($newEmail) || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "L'email doit être valide.";
                }

                // Check if credentials are taken by other users
                if (empty($errors)) {
                    $credentialCheck = UserService::checkForExistantCredentials($newUsername, $newEmail);
                    if ($credentialCheck === USERNAME_TAKEN && $user && $newUsername !== $user->username) {
                        $errors[] = "Ce nom d'utilisateur est déjà pris.";
                    }
                    if ($credentialCheck === EMAIL_TAKEN && $user && $newEmail !== $user->email) {
                        $errors[] = "Cet email est déjà utilisé.";
                    }
                }

                if (empty($errors)) {
                    $updatedUser = UserService::editUser($user->id, $newUsername, null, $newEmail);
                    if ($updatedUser) {
                        $user = $updatedUser; // Update local user object
                        $message = "Profil mis à jour avec succès.";
                        $messageType = 'success';
                    } else {
                        $message = "Erreur lors de la mise à jour du profil.";
                        $messageType = 'danger';
                    }
                } else {
                    $message = implode(' ', $errors);
                    $messageType = 'danger';
                }
                break;

            case 'change_password':
                $currentPassword = $_POST['current_password'] ?? '';
                $newPassword = $_POST['new_password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';

                // Validation
                $errors = [];
                if (empty($currentPassword)) {
                    $errors[] = "Le mot de passe actuel est requis.";
                }
                if (strlen($newPassword) < 6) {
                    $errors[] = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
                }
                if ($newPassword !== $confirmPassword) {
                    $errors[] = "Les mots de passe ne correspondent pas.";
                }

                // Verify current password
                if (empty($errors) && !password_verify($currentPassword, $user->password)) {
                    $errors[] = "Le mot de passe actuel est incorrect.";
                }

                if (empty($errors)) {
                    $updatedUser = UserService::editUser($user->id, null, $newPassword, null);
                    if ($updatedUser) {
                        $user = $updatedUser; // Update local user object
                        $message = "Mot de passe modifié avec succès.";
                        $messageType = 'success';
                    } else {
                        $message = "Erreur lors du changement de mot de passe.";
                        $messageType = 'danger';
                    }
                } else {
                    $message = implode(' ', $errors);
                    $messageType = 'danger';
                }
                break;
        }
    }
}
?>

<main class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-header mb-4">
                    <h1 class="page-title">
                        <i class="bi bi-gear me-2"></i>
                        Paramètres
                    </h1>
                    <p class="page-description">Gérez vos informations personnelles et paramètres de compte</p>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <!-- Profile Information -->
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-person-circle me-2"></i>
                                    Informations du profil
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" id="profileForm">
                                    <input type="hidden" name="action" value="update_profile">

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Nom d'utilisateur</label>
                                        <input type="text"
                                            class="form-control"
                                            id="username"
                                            name="username"
                                            value="<?= htmlspecialchars($user->username) ?>"
                                            required>
                                        <div class="form-text">Votre nom d'utilisateur unique</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Adresse email</label>
                                        <input type="email"
                                            class="form-control"
                                            id="email"
                                            name="email"
                                            value="<?= htmlspecialchars($user->email) ?>"
                                            required>
                                        <div class="form-text">Votre adresse email pour les notifications</div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Mettre à jour le profil
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Password Change -->
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-shield-lock me-2"></i>
                                    Changer le mot de passe
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" id="passwordForm">
                                    <input type="hidden" name="action" value="change_password">

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                                        <input type="password"
                                            class="form-control"
                                            id="current_password"
                                            name="current_password"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                                        <input type="password"
                                            class="form-control"
                                            id="new_password"
                                            name="new_password"
                                            minlength="6"
                                            required>
                                        <div class="form-text">Au moins 6 caractères</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                                        <input type="password"
                                            class="form-control"
                                            id="confirm_password"
                                            name="confirm_password"
                                            required>
                                    </div>

                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-key me-1"></i>
                                        Changer le mot de passe
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Informations du compte
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <strong>Statut du compte:</strong>
                                            <span class="badge bg-success ms-2">Actif</span>
                                        </div>
                                        <div class="info-item mb-3">
                                            <strong>Nombre d'appareils connectés:</strong>
                                            <span class="ms-2"><?= count($user->devices) ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <strong>Astracore version:</strong>
                                            <span class="badge bg-success ms-2">1.0.0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="/pages/js/settings.js"></script>
<link rel="stylesheet" href="/pages/css/dashboard/settings.css">