<?php
require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/User.php";

// Check login
$isLogged = isset($_SESSION['user']);

$isLogged = false; // Si le client est connecté
//$_SESSION["id"] = 3;
if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);

    if (empty($user)) {
        header("Location: ../");
    }
}
?>
<main class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-header mb-4">
                    <h1 class="page-title">
                        <i class="bi bi-hdd-stack me-2"></i>
                        List all Devices
                    </h1>
                    <p class="page-description">Connect a new device to your AstraCore account</p>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-list-check me-2"></i>
                                    My Devices (<?= count($user->getDevices()) ?>)
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="devices-summary">
                                    <?php foreach ($user->getDevices() as $device): ?>
                                        <div class="device-item d-flex justify-content-between align-items-center mb-2 p-2 rounded" data-toggle="tooltip" data-placement="top" title="The token is hidden for security">
                                            <div class="device-info d-flex align-items-center">
                                                <span class="invisible">..</span>
                                                <i class="bi bi-pc-display text-success me-2"></i>
                                                <span class="invisible">....</span>
                                                <div>
                                                    <strong class="text-white">IP: <?= htmlspecialchars($device->getIp()) ?></strong>
                                                    <small class="text-white d-block">
                                                        Token: <span class="text-secondary"><?= str_repeat("*", strlen(htmlspecialchars(substr($device->getLocalMachineToken(), 0, 255))))  ?></span>
                                                    </small>
                                                </div>
                                            </div>
                                            <span class="badge bg-success" data-toggle="tooltip" data-placement="top" title="Server correctly connected">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Connected
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="dashboard/?tab=devices-add" class="btn btn-outline-secondary">
                                        <i class="bi bi-database-add me-1"></i>
                                        Add a new device
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<link rel="stylesheet" href="/astracore/pages/css/add_devices.css">

<link rel="stylesheet" href="/astracore/pages/css/settings.css">

<style>
    .card {
        margin: 45px;
    }
</style>