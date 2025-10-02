<?php
require_once "class/UserService.php";
require_once "class/SessionHandler.php";
require_once "class/User.php";
require_once "class/utils/logger/LogError.php";
require_once "class/utils/logger/LogWarning.php";

if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);

    if (!empty($user)) {
        header("Location: ./dashboard/");
    }
}

$error = false;
$login = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = trim(filter_input(INPUT_POST, "login", FILTER_SANITIZE_SPECIAL_CHARS));
    $password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
    $error = empty($login) || empty($password);

    if(!$error) {
        $user = UserService::login($login, $password);

        if (!empty($user)) {
            SaveInSession("userId", $user->id);
            header("Location: ./dashboard/");
        } else {
            new LogWarning("Failed login attempt for user: $login", "AUTH");
            $error = true;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - AstraCore.cloud</title>
    <link rel="stylesheet" href="pages/css/login.css">
    <link rel="stylesheet" href="pages/css/header.css">
    <link rel="stylesheet" href="pages/css/footer.css">
    <link rel="stylesheet" href="pages/css/utils.css">
    <script type="text/javascript" src="pages/js/login.js" defer></script>
</head>

<body>
    <!-- Animated Grid Background -->
    <div class="grid-background"></div>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="../astracore" class="logo">AstraCore</a>
        <div class="nav-buttons">
            <a href="signup" class="btn btn-ghost">Sign Up</a>
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

                <button type="submit" class="btn btn-primary">Log In</button>

                <!-- <div class="forgot-password">
                    <a href="#" class="auth-link" onclick="showForgotPassword()">Forgot your password?</a>
                </div> -->
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-links">
            <a href="#" class="footer-link">Privacy Policy</a>
            <a href="#" class="footer-link">Terms of Service</a>
            <a href="#" class="footer-link">Contact Support</a>
        </div>
        <div class="footer-copyright">
            &copy; <?= date("Y") ?> AstraCore.cloud - All rights reserved
        </div>
    </footer>
</body>

</html>