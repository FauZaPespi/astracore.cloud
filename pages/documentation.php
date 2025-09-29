<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "class/UserService.php";
require_once "class/SessionHandler.php";
require_once "class/User.php";
require_once "class/utils/logger/LogError.php";
require_once "class/utils/logger/LogSuccess.php";

$isLogged = false;

if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);
    $isLogged = !empty($user);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstraCore.cloud - One Website. Thousands of Machines. Full Control.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="pages/css/home.css">
    <link rel="stylesheet" href="pages/css/header.css">
    <link rel="stylesheet" href="pages/css/footer.css">
    <link rel="stylesheet" href="pages/css/utils.css">
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
</head>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "class/UserService.php";
require_once "class/SessionHandler.php";
require_once "class/User.php";
require_once "class/utils/logger/LogError.php";
require_once "class/utils/logger/LogSuccess.php";

$isLogged = false;

if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);
    $isLogged = !empty($user);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstraCore.cloud - Documentation & Release Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="pages/css/home.css">
    <link rel="stylesheet" href="pages/css/header.css">
    <link rel="stylesheet" href="pages/css/footer.css">
    <link rel="stylesheet" href="pages/css/utils.css">
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="logo">AstraCore</a>
        <ul class="nav-links">
            <li><a href="#docs">Docs</a></li>
            <li><a href="#changelog">Changelog</a></li>
            <li><a href="#faq">FAQ</a></li>
        </ul>
        <div class="nav-buttons">
            <?= !$isLogged ? '<a href="login" class="btn btn-ghost">Login</a>' : "" ?>
            <a href="<?= $isLogged ? "dashboard/" : "signup" ?>" class="btn btn-primary">
                <?= $isLogged ? "Dashboard" : "Get Started" ?>
            </a>
        </div>
    </nav>

    <!-- Hero / Docs Header -->
    <section class="hero d-flex flex-column justify-content-center text-center">
        <div class="hero-bg"></div>
        <div class="hero-content container">
            <h1>Documentation & Release Notes</h1>
            <p class="hero-subtitle">
                Stay up-to-date with the latest features, improvements, and bug fixes for AstraCore.
                Browse the docs to understand how to get the most out of the platform.
            </p>
        </div>
    </section>

    <!-- Documentation / Changelog -->
    <section id="docs" class="py-5">
        <div class="container">
            <h2 class="section-title mb-4 text-center">📖 Documentation</h2>

            <div class="accordion" id="docsAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSetup">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetup">
                            Getting Started
                        </button>
                    </h2>
                    <div id="collapseSetup" class="accordion-collapse collapse show" data-bs-parent="#docsAccordion">
                        <div class="accordion-body">
                            Learn how to connect your first Linux machine to AstraCore, configure users, and deploy your first command.
                            <br><a href="#">➡ Read the full guide</a>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSecurity">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecurity">
                            Security Features
                        </button>
                    </h2>
                    <div id="collapseSecurity" class="accordion-collapse collapse" data-bs-parent="#docsAccordion">
                        <div class="accordion-body">
                            Learn more about encryption, role-based access control, and audit logging.
                            <br><a href="#">➡ Security documentation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Changelog Section -->
    <section id="changelog" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title mb-4 text-center">📝 Changelog</h2>

            <div class="changelog-entry mb-4">
                <h4>v1.2.0 - September 2025</h4>
                <ul>
                    <li>✨ Added <strong>Custom Command Scheduler</strong> for recurring tasks</li>
                    <li>🔐 Improved <strong>Two-Factor Authentication</strong></li>
                    <li>🐛 Fixed bug with server group syncing</li>
                </ul>
            </div>

            <div class="changelog-entry mb-4">
                <h4>v1.1.0 - August 2025</h4>
                <ul>
                    <li>⚡ Optimized performance for large infrastructures (10k+ servers)</li>
                    <li>📊 New dashboard widgets for resource monitoring</li>
                    <li>🚀 Faster deployment of server commands</li>
                </ul>
            </div>

            <div class="changelog-entry">
                <h4>v1.0.0 - July 2025</h4>
                <ul>
                    <li>🎉 Initial public release</li>
                    <li>👤 User management + RBAC</li>
                    <li>🖥️ Server connection via secure agent</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-5">
        <div class="container">
            <h2 class="section-title mb-4 text-center">❓ FAQ</h2>
            <div class="row justify-content-center">
                <div class="col-md-8 text-start">
                    <p><strong>Q: How do I connect my first server?</strong><br>
                        A: Simply install the AstraCore agent and use the dashboard to link it with your account.</p>
                    <p><strong>Q: Is my data encrypted?</strong><br>
                        A: Yes, we use end-to-end encryption for all communications between your servers and AstraCore.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container text-center">
            <div class="footer-links mb-3 d-flex justify-content-center gap-3 flex-wrap">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-copyright">
                &copy; <?= date("Y") ?> AstraCore.cloud - All rights reserved
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
