<?php
session_start();
require_once __DIR__ . "/../../class/SessionHandler.php";
require_once __DIR__ . "/../../class/UserService.php";
require_once __DIR__ . "/../../class/DeviceService.php";
require_once __DIR__ . "/../../class/User.php";
require_once __DIR__ . "/../../class/Device.php";
require_once __DIR__ . "/../../class/utils/popUp/PopUpNotification.php";
$user = null;
if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);
    $isLogged = !empty($user);
}

$message = '';
$messageType = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_device') {
        $deviceIp = trim($_POST['device_ip'] ?? '');
        $deviceToken = trim($_POST['device_token'] ?? '');

        // Validation
        $errors = [];
        if (empty($deviceIp)) {
            $errors[] = "Device IP address is required.";
        } elseif (!filter_var($deviceIp, FILTER_VALIDATE_IP)) {
            $errors[] = "Invalid IP address.";
        }

        if (empty($deviceToken)) {
            $errors[] = "Device token is required.";
        } elseif (strlen($deviceToken) < 16) {
            $errors[] = "Token must be at least 16 characters long.";
        }

        // Check if device is already registered
        if (empty($errors)) {
            if (DeviceService::isAlreadyAdded($deviceIp)) {
                $errors[] = "This device is already registered in AstraCore.";
            }
        }

        if (empty($errors)) {

            if($user->role == UserRole::Member && count($user->devices) >= 3)
            {
                $message = "Max server limit reached, please subscribe to add more servers!";
                $messageType = 'danger';
            }
            else
            {
                $device = DeviceService::addDevice($deviceIp, $deviceToken, $user->id);

                if ($device) {
                    // Refresh user data to show the new device
                    $user = UserService::getUserById($_SESSION["userId"]);
                    $message = "Device successfully added!";
                    $messageType = 'success';

                    // Clear form fields
                    $deviceIp = '';
                    $deviceToken = '';
                } else {
                    $message = "Error while adding device.";
                    $messageType = 'danger';
                }
            }

        } else {
            $message = implode(' ', $errors);
            $messageType = 'danger';
        }
    }
}
?>
<?php
// Show popup if ?popup=form_incomplete is in the URL
if (isset($_GET['popup']) && $_GET['popup'] === 'form_incomplete') {
    new PopUpNotification("Form Incomplete", "Please enter the IP and token before testing the connection.");
}
?>
</div>
<main class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-header mb-4">
                    <h1 class="page-title">
                        <i class="bi bi-plus-circle me-2"></i>
                        Add a Device
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
                    <!-- Add Device Form -->
                    <div class="col-lg-8 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-pc-display me-2"></i>
                                    New Device
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" id="addDeviceForm">
                                    <input type="hidden" name="action" value="add_device">

                                    <div class="mb-3">
                                        <label for="device_ip" class="form-label">
                                            <i class="bi bi-globe2 me-1"></i>
                                            Device IP Address
                                        </label>
                                        <input type="text"
                                            class="form-control"
                                            id="device_ip"
                                            name="device_ip"
                                            value="<?= htmlspecialchars($deviceIp ?? '') ?>"
                                            placeholder="192.168.1.100"
                                            required>
                                        <div class="form-text">
                                            The local or public IP address of your device
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="device_token" class="form-label">
                                            <i class="bi bi-key me-1"></i>
                                            Authentication Token
                                        </label>
                                        <input type="text"
                                            class="form-control"
                                            id="device_token"
                                            name="device_token"
                                            value="<?= htmlspecialchars($deviceToken ?? '') ?>"
                                            placeholder="abcd1234-efgh5678-ijkl9012-mnop3456"
                                            required>
                                        <div class="form-text">
                                            The unique token generated by your AstraCore device
                                        </div>
                                    </div>

                                    <div class="device-status mb-3">
                                        <div class="status-indicator">
                                            <i class="bi bi-circle-fill text-secondary me-2"></i>
                                            <span class="status-text">Status: Waiting for connection</span>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add the device to your account">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Add Device
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="testConnection()" data-toggle="tooltip" data-placement="top" title="Test the connection to your device">
                                            <i class="bi bi-wifi me-1"></i>
                                            Test Connection
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions & Info -->
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Instructions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="instruction-step mb-3">
                                    <div class="step-number">1</div>
                                    <div class="step-content">
                                        <strong>Install AstraCore</strong>
                                        <p>Download and install the AstraCore agent on your device.</p>
                                    </div>
                                </div>

                                <div class="instruction-step mb-3">
                                    <div class="step-number">2</div>
                                    <div class="step-content">
                                        <strong>Get the token</strong>
                                        <p>Copy the token generated during installation from your device.</p>
                                    </div>
                                </div>

                                <div class="instruction-step mb-3">
                                    <div class="step-number">3</div>
                                    <div class="step-content">
                                        <strong>Add the device</strong>
                                        <p>Enter the IP and token in the form on the left.</p>
                                    </div>
                                </div>

                                <div class="download-section mt-4">
                                    <h6 class="text-white text-wrap mb-2">
                                        <i class="bi bi-download me-1"></i>
                                        Downloads
                                    </h6>
                                    <div class="d-grid gap-2">
                                        <a href="/download?platform=linux" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Download the Linux agent">
                                            <i class="bi bi-tux me-1"></i>
                                            Linux Agent
                                        </a>
                                        <a href="/download?platform=win" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Download the Linux agent">
                                            <i class="bi bi-windows me-1"></i>
                                            Windows Agent
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Devices Summary -->
                <?php if (isset($user->devices) == true): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-list-check me-2"></i>
                                        My Devices (<?= count($user->devices) ?>)
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
                                                <span class="badge bg-success" data-toggle="tooltip" data-placement="top" title="Server correctly connected">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Connected
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="text-center mt-3">
                                        <a href="dashboard/?tab=devices-list" class="btn btn-outline-secondary">
                                            <i class="bi bi-list-ul me-1"></i>
                                            View all devices
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
    // Test connection functionality
    function testConnection() {
        const ip = document.getElementById('device_ip').value;
        const token = document.getElementById('device_token').value;

        if (!ip || !token) {
            // Reload page with GET parameter to trigger server-side popup
            const url = new URL(window.location.href);
            url.searchParams.set('popup', 'form_incomplete');
            window.location.href = url.toString();
            return;
        }


        // Update status indicator
        const statusIndicator = document.querySelector('.status-indicator i');
        const statusText = document.querySelector('.status-text');

        statusIndicator.className = 'bi bi-circle-fill text-warning me-2';
        statusText.textContent = 'Status: Testing connection...';

        // Simulate connection test (replace with actual API call)
        setTimeout(() => {
            // For demo purposes, randomly succeed or fail
            const success = Math.random() > 0.3;

            if (success) {
                statusIndicator.className = 'bi bi-circle-fill text-success me-2';
                statusText.textContent = 'Status: Connection successful!';
            } else {
                statusIndicator.className = 'bi bi-circle-fill text-danger me-2';
                statusText.textContent = 'Status: Connection failed';
            }
        }, 2000);
    }

    // Form validation
    document.getElementById('addDeviceForm').addEventListener('submit', function(e) {
        const ip = document.getElementById('device_ip').value;
        const token = document.getElementById('device_token').value;

        // Basic IP validation
        const ipPattern = /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;

        if (!ipPattern.test(ip)) {
            e.preventDefault();
            alert('Please enter a valid IP address.');
            document.getElementById('device_ip').focus();
            return;
        }

        if (token.length < 16) {
            e.preventDefault();
            alert('The token must be at least 16 characters long.');
            document.getElementById('device_token').focus();
            return;
        }
    });
</script>

<link rel="stylesheet" href="/pages/css/dashboard/add_devices.css">

<link rel="stylesheet" href="/pages/css/dashboard/settings.css">