<?php
session_start();
require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/User.php";
require_once "class/DeviceService.php";
require_once "class/Device.php";
$user = null;
if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);
    $isLogged = !empty($user);
}

// Handle device deletion.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['device_id']) && isset($_POST['device_token'])) {
        $deviceId = intval($_POST['device_id'] ?? 0);   
        $deviceToken = $_POST['device_token'] ?? '';
        $result = DeviceService::deleteDevice($user->id, $deviceToken);
        new LogInfo("Device with ID $deviceId removed by user ID " . $user->id);
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
                                    My Devices (<?php if (isset($user->devices) == true) {echo count($user->devices); } else { echo "0"; } ?>)
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="devices-summary">
                                    <?php foreach ($user->devices as $device): ?>
                                        <div class="device-item d-flex justify-content-between align-items-center mb-2 p-2 rounded" data-toggle="tooltip" data-placement="top" title="The token is hidden for security">
                                            <div class="device-info d-flex align-items-center">
                                                <span class="invisible">..</span>
                                                <i class="bi bi-pc-display text-success me-2"></i>
                                                <span class="invisible">....</span>
                                                <div>
                                                    <strong class="text-white">IP: <?= htmlspecialchars($device->ip) ?></strong>
                                                    <small class="text-white d-block">
                                                        Token: <span class="text-secondary"><?= str_repeat("*", strlen(htmlspecialchars(substr($device->localMachineToken, 0, 255))))  ?></span>
                                                    </small>
                                                </div>
                                            </div>
                                            <span class="badge bg-primary" data-toggle="tooltip" data-placement="top" title="Device ID">
                                                <i class="bi bi-hash me-1"></i>
                                                <?= $device->id ?>
                                            </span>
                                            <form method="POST">
                                                <input type="hidden" name="device_id" value="<?= $device->id ?>">
                                                <input type="hidden" name="device_token" value="<?= $device->localMachineToken ?>">
                                                <button class="btn badge bg-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Remove this device">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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


<link rel="stylesheet" href="/pages/css/dashboard/add_devices.css">
<link rel="stylesheet" href="/pages/css/dashboard/settings.css">