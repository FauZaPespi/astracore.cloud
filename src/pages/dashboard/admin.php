<?php

session_start();

require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/User.php";
require_once "class/DeviceService.php";
require_once "class/Device.php";
if ($_SESSION["role"] !== "admin") {
    new LogWarning("Tentative d'accès à l'admin panel sans authorisation");
    header("Location: /dashboard");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteUser'])) {
        $userId = intval($_POST['deleteUser'] ?? 0);
        if (UserService::deleteUser($userId) == true) {
            echo "User deleted with success";
        }
    }
}

$users = UserService::getAllUser();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <base href="/pages">
    <link rel="stylesheet" href="pages/css/utils/variables.css">
    <link rel="stylesheet" href="pages/css/utils/buttons.css">
    <link rel="stylesheet" href="pages/css/utils/forms.css">
    <link rel="stylesheet" href="pages/css/utils/animations.css">
    <link rel="stylesheet" href="pages/css/base/layout.css">
    <link rel="stylesheet" href="pages/css/dashboard/admin.css">
    <link rel="stylesheet" href="pages/css/dashboard/sidebar.css">
    <link rel="icon" type="image/x-icon" href="pages/assets/AstraCore.ico">
</head>

<body>
    <header>

    </header>
    <main class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-header mb-4">
                        <h1 class="page-title">
                            <i class="bi bi-person-gear"></i>
                            List all Users
                        </h1>
                        <p class="page-description">This the list of every registered User</p>
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <div class="card bg-black">
                                <div class="card-body">
                                    <div class="devices-summary">
                                        <?php foreach ($users as $currentUser){ ?>
                                            <div class="bg-black device-item d-flex justify-content-between align-items-center mb-2 p-2 rounded" data-toggle="tooltip" data-placement="top" title="The token is hidden for security">
                                                <div class="device-info d-flex align-items-center">
                                                    <span class="invisible">..</span>
                                                    <i class="bi bi-person text-white"></i>
                                                    <span class="invisible">....</span>
                                                    <div>
                                                        <strong class="text-white"><?php echo $currentUser["username"]; ?></strong>
                                                    </div>
                                                </div>
                                                <span class="text-white badge" data-toggle="tooltip" data-placement="top" title="User Email">
                                                    <?php echo $currentUser["email"]; ?>
                                                </span>
                                                <form method="POST">
                                                    <input type="hidden" name="deleteUser" value="<?= $currentUser["id"] ?>">
                                                    <button class="btn badge bg-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Delete this user">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="pages/js/animation.js"></script>
    <link rel="stylesheet" href="/pages/css/dashboard/settings.css">
</body>