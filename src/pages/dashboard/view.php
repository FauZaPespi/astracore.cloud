<?php
session_start();
require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/User.php";
session_start();
$user = null;
if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);
    $isLogged = !empty($user);
}

// Logout handling

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: /login');
    die();
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
    <base href="/">
    <link rel="stylesheet" href="pages/css/utils/variables.css">
    <link rel="stylesheet" href="pages/css/utils/buttons.css">
    <link rel="stylesheet" href="pages/css/utils/forms.css">
    <link rel="stylesheet" href="pages/css/utils/animations.css">
    <link rel="stylesheet" href="pages/css/utils/popup.css">
    <link rel="stylesheet" href="pages/css/dashboard/sidebar.css">
    <link rel="stylesheet" href="pages/css/dashboard/modules.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            case 'settings':
                require_once __DIR__ . '/settings.php';
                break;
            case "admin":
                if ($_SESSION["role"] == "admin")
                {
                    require_once __DIR__ . '/admin.php';
                }
                else
                {
                    require_once __DIR__ . '/devices.php';
                }
                break;
            case 'curious':
                echo "<h1>You're curious, aren't you?</h1>";
                break;
            default:
                http_response_code(404);
                echo "<h1>404 - Tab Not Found</h1>";
                exit();
        }
    } else {
        header("Location: ?tab=devices-list");
        die();
    }
    ?>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container text-center">
            <div class="footer-links mb-3 d-flex justify-content-center gap-3 flex-wrap">
                <a href="privacy-policy">Privacy</a>
                <a href="terms-of-use">Terms</a>
                <a href="mailto:support@astracore.cloud">Contact</a>
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