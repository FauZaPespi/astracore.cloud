<?php
session_start();
require_once "/var/www/html/class/UserService.php";
require_once "/var/www/html/class/SessionHandler.php";
require_once "/var/www/html/class/User.php";
require_once "/var/www/html/class/utils/logger/LogError.php";
require_once "/var/www/html/class/utils/logger/LogWarning.php";

$error = false;
$login = "";
$password = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = trim(filter_input(INPUT_POST, "login", FILTER_SANITIZE_SPECIAL_CHARS));
    $password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
    $error = empty($login) || empty($password);

    if (!$error) {
        $user = UserService::login($login, $password);
        if (!empty($user)) {
            $_SESSION["userId"] = $user->id;
            new LogInfo("Connexion faite avec l'user correspondant à l'id : ". $user->id, "AUTH");
            $_SESSION["role"] = $user->role->value;
            header("Location: /dashboard");
            die;
        } else {
            new LogWarning("Failed login attempt for user: $login", "AUTH");
            $error = true;
        }
    }
    else
    {
        new LogWarning("Erreur lor du login", "AUTH");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - AstraCore.cloud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="pages/css/utils/variables.css">
    <link rel="stylesheet" href="pages/css/utils/buttons.css">
    <link rel="stylesheet" href="pages/css/utils/forms.css">
    <link rel="stylesheet" href="pages/css/utils/animations.css">
    <link rel="stylesheet" href="pages/css/base/auth.css">
    <link rel="stylesheet" href="pages/css/base/layout.css">
    <script type="text/javascript" src="pages/js/login.js" defer></script>
</head>

<body>
    <!-- Animated Grid Background -->
    <div class="grid-background"></div>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="/" class="logo">AstraCore</a>
        <div class="nav-buttons">
            <a href="signup" class="btn btn-ghost">Register</a>
        </div>
    </nav>

    <!-- Login Page -->
    <div class="main-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Welcome back to AstraCore</h1>
                <p class="auth-subtitle">Log in to access your intelligent cloud dashboard</p>
            </div>

            <form class="auth-form" method="post">
                <div class="form-group">
                    <label class="form-label" for="login">Email or Username</label>
                    <input
                        type="text"
                        name="login"
                        id="login"
                        value="<?= $login ?>"
                        class="form-input"
                        placeholder="email@example.com"
                        required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        value="<?= $password ?>"
                        class="form-input"
                        placeholder="Enter your password"
                        required>
                </div>

                <?= $error ? "<p class='error'>Invalid credentials, please try again.</p>" : "" ?>

                <button type="submit" class="btn btn-primary">Log-In</button>

                <!-- <div class="forgot-password">
                    <a href="#" class="auth-link" onclick="showForgotPassword()">Forgot your password?</a>
                </div> -->
                
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">

                <!-- Center Content -->
                <div class="col-md-8 offset-md-2 text-center">
                    <div class="footer-links d-flex justify-content-center gap-3 flex-wrap mb-2">
                        <a href="privacy-policy">Privacy</a>
                        <a href="terms-of-use">Terms</a>
                        <a href="mailto:support@astracore.cloud">Contact</a>
                    </div>
                    <div class="footer-copyright">
                        &copy; <?= date("Y") == "2025" ? date("Y") :  "2025 - " . date("Y"); ?> AstraCore.cloud - All rights reserved
                    </div>
                </div>

                <!-- Right GitHub Link -->
                <div class="col-md-2 text-center text-md-end mt-3 mt-md-0">
                    <a href="https://github.com/Res-NeoTech/astracore_receiver" target="_blank" class="github-link text-decoration-none">
                        <i class="bi bi-github"></i> Open Source
                    </a>
                </div>

            </div>
        </div>
    </footer>
</body>

</html>