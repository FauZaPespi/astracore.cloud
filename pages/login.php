<?php
require_once "class/UserService.php";
require_once "class/SessionHandler.php";
require_once "class/User.php";

if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);

    if (!empty($user)) {
        header("Location: ./dashboard/");
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

            <form class="auth-form" onsubmit="handleSubmit(event)">
                <div class="form-group">
                    <label class="form-label" for="login-email">Email Address</label>
                    <input
                        type="email"
                        id="login-email"
                        class="form-input"
                        placeholder="you@company.com"
                        required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="login-password">Password</label>
                    <input
                        type="password"
                        id="login-password"
                        class="form-input"
                        placeholder="Enter your password"
                        required>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="remember-me" class="checkbox">
                    <label for="remember-me" class="checkbox-label">Remember me for 30 days</label>
                </div>

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
            © 2025 AstraCore.cloud - All rights reserved
        </div>
    </footer>
</body>

</html>