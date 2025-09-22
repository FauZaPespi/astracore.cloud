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

<body>
    <?php
    // Exemple logs
    //$logError = new LogError("Test error log", true);
    //$successLog = new LogSuccess("Test success log", true);
    ?>
    <!-- Navbar -->
    <nav class="navbar"> <a href="#" class="logo">AstraCore</a>
        <ul class="nav-links">
            <li><a href="#overview">Overview</a></li>
            <li><a href="#organisation">Organisation</a></li>
            <li><a href="#docs">Docs</a></li>
        </ul>
        <div class="nav-buttons"> <?= !$isLogged ? '<a href="login" class="btn btn-ghost">Login</a>' : "" ?> <a href="<?= $isLogged ? "dashboard/" : "signup" ?>" class="btn btn-primary"><?= $isLogged ? "Dashboard" : "Get Started" ?></a> </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero d-flex flex-column justify-content-center text-center">
        <div class="hero-bg"></div>
        <div class="hero-content container">
            <h1>One Website. <br>Thousands of Machines. <br>Full Control.</h1>
            <p class="hero-subtitle">
                AstraCore is the next-generation SaaS platform for centralized Linux server management.
                Control your entire infrastructure from a single, powerful interface.
            </p>
            <div class="hero-buttons d-flex justify-content-center gap-2 flex-wrap">
                <a href="<?= $isLogged ? "dashboard/" : "signup" ?>" class="btn btn-primary"><?= $isLogged ? "Dashboard" : "Get Started" ?></a>
                <a href="#" class="btn btn-outline">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Overview Section -->
    <section class="overview fade-in py-5" id="overview">
        <div class="container">
            <h2 class="section-title mb-5 text-center">Why AstraCore?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon"><i class="bi bi-gear-wide-connected fs-1"></i></div>
                        <h3>Centralized Control</h3>
                        <p>Manage thousands of Linux machines from a single dashboard. No more SSH chaos, no more configurations.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon"><i class="bi bi-lock-fill fs-1"></i></div>
                        <h3>Secure by Design</h3>
                        <p>Enterprise-grade security with end-to-end encryption, role-based access control, and comprehensive audit logs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon"><i class="bi bi-terminal-fill fs-1"></i></div>
                        <h3>Custom Commands</h3>
                        <p>Create, deploy, and execute custom commands across your infrastructure with advanced scheduling and automation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Organisation Section -->
    <section class="organisation fade-in py-5" id="organisation">
        <div class="container text-center">
            <h2 class="section-title mb-3">Our Development Approach</h2>
            <p class="org-subtitle mb-4">
                Built with a modern, efficient, and low-level tech stack to guarantee optimal performance and unlock the full potential of your server.
            </p>
            <div class="row justify-content-center g-4">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="team-card">
                        <img class="team-avatar" src="https://api.fauza.dev/discord/pfp.php" alt="FauZa" onerror="this.onerror=null; this.src='https://placehold.co/1200x1200/1A1F2C/9b87f5?text=FZ';" draggable="false">
                        <h4>FauZa</h4>
                        <p>Full-Stack Developer, Co-Founder</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="team-card">
                        <img class="team-avatar" src="https://cdn.maksym.ch/pfp" alt="NeoTech" onerror="this.onerror=null; this.src='https://placehold.co/1200x1200/1A1F2C/9b87f5?text=NT';" draggable="false">
                        <h4>NeoTech</h4>
                        <p>Full-Stack Developer, Co-Founder</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="final-cta fade-in py-5 text-center">
        <div class="container">
            <h2 class="cta-title mb-3">Ready to take control of your infrastructure?</h2>
            <p>Connect your server to AstroCore in seconds and effortlessly manage your entire infrastructure from a single dashboard.</p>
            <br>
            <a href="<?= $isLogged ? "dashboard" : "login" ?>" class="btn btn-outline"><i class="bi bi-database-fill-add"></i><span class="invisible">..</span>Connect my server</a>
        </div>
        <?php
        for ($i = 0; $i < 3; $i++) {
            echo "<br>";
        }
        ?>

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
                &copy; <?= date("Y") == "2025" ?  date("Y") : "2025" - date("Y") ?> AstraCore.cloud - All rights reserved
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="pages/js/animation.js"></script>
    <script src="pages/js/home.js"></script>
</body>

</html>