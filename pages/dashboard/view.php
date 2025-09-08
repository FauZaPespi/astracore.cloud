<?php
require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/User.php";

// Check login
$isLogged = isset($_SESSION['user']);

$isLogged = false; // Si le client est connecté

if (isset($_SESSION["id"])) {
    $user = UserService::getUserById($_SESSION["id"]);

    $isLogged = !empty($user);
}

// Logout handling
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: /astracore.cloud/login");
    exit();
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
    <link rel="stylesheet" href="../pages/css/home.css">
    <link rel="stylesheet" href="../pages/css/header.css">
    <link rel="stylesheet" href="../pages/css/footer.css">
    <link rel="stylesheet" href="../pages/css/utils.css">
    <link rel="stylesheet" href="../pages/css/nav.css">
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
</head>

<body class="has-sidebar">

    <?php
    require_once __DIR__ . '/nav.php';
    if (isset($_GET['tab'])) {
        switch ($_GET['tab']) {
            case "devices-list":
                require_once __DIR__ . '/devices.php';
                break;
            case 'modules-list':
                require_once __DIR__ . '/modules.php';
                break;
            case 'devices-add':
                require_once __DIR__ . '/add_devices.php';
                break;
            default:
                http_response_code(404);
                echo "<h1>404 - Tab Not Found</h1>";
                exit();
        }
    } else {
        exit();
    }
    ?>

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