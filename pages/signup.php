<?php
require_once "class/UserService.php";
require_once "class/SessionHandler.php";
require_once "class/User.php";
require_once "class/utils/LoggerOscar.php";

if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);

    if (!empty($user)) {
        header("Location: ./dashboard/");
    }
}

$diagnostics = [
    "username" => "",
    "email" => "",
    "password" => ""
];

$username = "";
$email = "";
$password = "";
$rPassword = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim(filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL));
    $password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
    $rPassword = filter_input(INPUT_POST, "rPassword", FILTER_UNSAFE_RAW);

    if (strlen($username) < 3 || strlen($username) > 45) {
        $diagnostics["username"] = "Username length is invalid.";
    }

    if (empty($email) || strlen($email) > 200) {
        $diagnostics["email"] = "Email format is invalid.";
    }

    if ($password !== $rPassword) {
        $diagnostics["password"] = "Passwords do not match. Please follow the instructions.";
    }

    switch (UserService::checkForExistantCredentials($username, $email)) {
        case AVAILABLE:
            $user = UserService::createUser($username, $password, $email);
            log_Oscar::Tlog("New user created with ID: $id ($username)", 'SUCCESS');
            SaveInSession("userId", $user->getId());
            break;
        case USERNAME_TAKEN:
            $diagnostics["username"] = $username . " is already taken.";
            log_Oscar::Tlog($username . " is already taken.", 'WARNING');
            break;
        case EMAIL_TAKEN:
            $diagnostics["email"] = $email . " is already taken.";
            break;
        default:
            $diagnostics["password"] = "Server-side exception occured. Please, try again later.";
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - AstraCore.cloud</title>
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
    <script type="text/javascript" src="pages/js/signup.js" defer></script>
    <link rel="stylesheet" href="pages/css/signup.css">
    <link rel="stylesheet" href="pages/css/header.css">
    <link rel="stylesheet" href="pages/css/footer.css">
    <link rel="stylesheet" href="pages/css/utils.css">
</head>

<body>
    <!-- Animated Grid Background -->
    <div class="grid-background"></div>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="../astracore" class="logo">AstraCore</a>
        <div class="nav-buttons">
            <a href="login" class="btn btn-ghost">Login</a>
        </div>
    </nav>

    <!-- Signup Page -->
    <div class="main-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Create your AstraCore account</h1>
                <p class="auth-subtitle">Join the future of cloud computing and data intelligence</p>
            </div>

            <form class="auth-form" method="post">
                <div class="form-group">
                    <label class="form-label" for="signup-name">Username</label>
                    <input
                        type="text"
                        id="signup-name"
                        name="username"
                        maxlength="45"
                        minlength="3"
                        class="form-input"
                        placeholder="Enter your username"
                        value="<?= $username ?>"
                        required>
                </div>

                <?= empty($diagnostics["username"]) ? "" : "<p class='error'>" . $diagnostics["username"] . "</p>" ?>

                <div class="form-group">
                    <label class="form-label" for="signup-email">Email Address</label>
                    <input
                        type="email"
                        id="signup-email"
                        name="email"
                        class="form-input"
                        placeholder="you@company.com"
                        value="<?= $email ?>"
                        required>
                </div>

                <?= empty($diagnostics["email"]) ? "" : "<p class='error'>" . $diagnostics["email"] . "</p>" ?>

                <div class="form-group">
                    <label class="form-label" for="signup-password">Password</label>
                    <input
                        type="password"
                        id="signup-password"
                        name="password"
                        class="form-input"
                        placeholder="Create a strong password"
                        value="<?= $password ?>"
                        required>
                </div>

                <?= empty($diagnostics["password"]) ? "" : "<p class='error'>" . $diagnostics["password"] . "</p>" ?>

                <div class="form-group">
                    <label class="form-label" for="signup-confirm">Confirm Password</label>
                    <input
                        type="password"
                        id="signup-confirm"
                        name="rPassword"
                        class="form-input"
                        placeholder="Confirm your password"
                        value="<?= $rPassword ?>"
                        required>
                </div>

                <div class="form-group">
                    <p class="error" id="passwordMatchError"></p>
                </div>

                <button type="submit" id="submit" class="btn btn-primary">Create Account</button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="login" class="auth-link">Sign in here</a></p>
            </div>
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