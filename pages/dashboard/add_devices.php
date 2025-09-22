<?php
require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/User.php";
require_once "class/Device.php";
require_once "class/utils/popUp/PopUpNotification.php";

// Check login
if (!isset($_SESSION["userId"])) {
    header("Location: ../");
    exit();
}

$user = UserService::getUserById($_SESSION["userId"]);
if (empty($user)) {
    header("Location: ../");
    exit();
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
            if (UserService::isDeviceRegistered($user->getId(), $deviceToken)) {
                $errors[] = "This device is already registered to your account.";
            }
        }

        if (empty($errors)) {
            $device = new Device($deviceIp, $deviceToken);
            $success = UserService::registerDevice($user->getId(), $device);

            if ($success) {
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
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Add Device
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="testConnection()">
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
                                        <a href="/astracore/download?platform=linux" class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-tux me-1"></i>
                                            Linux Agent
                                        </a>
                                        <a href="/astracore/download?platform=win" class="btn btn-outline-dark btn-sm">
                                            <i class="bi bi-windows me-1"></i>
                                            Windows Agent (Coming Soon)
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Devices Summary -->
                <?php if (count($user->getDevices()) > 0): ?>
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
                                            <div class="device-item d-flex justify-content-between align-items-center mb-2 p-2 rounded">
                                                <div class="device-info d-flex align-items-center">
                                                    <i class="bi bi-pc-display text-success me-2"></i>
                                                    <div>
                                                        <strong><?= htmlspecialchars($device->getIp()) ?></strong>
                                                        <small class="text-muted d-block">
                                                            Token: <?= htmlspecialchars(substr($device->getLocalMachineToken(), 0, 16)) ?>...
                                                        </small>
                                                    </div>
                                                </div>
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Connected
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="text-center mt-3">
                                        <a href="dashboard/?tab=devices-list" class="btn btn-outline-primary">
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

<style>
    .device-status {
        background: rgba(15, 157, 102, 0.05);
        border: 1px solid rgba(15, 157, 102, 0.2);
        border-radius: 8px;
        padding: 1rem;
    }

    .status-indicator {
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .instruction-step {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .step-number {
        background: linear-gradient(135deg, var(--green-primary), var(--green-accent));
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .step-content strong {
        color: var(--white);
        font-size: 0.95rem;
    }

    .step-content p {
        color: var(--gray-light);
        font-size: 0.875rem;
        margin: 0.25rem 0 0 0;
        line-height: 1.4;
    }

    .download-section {
        border-top: 1px solid rgba(233, 233, 233, 0.1);
        padding-top: 1rem;
    }

    .device-item {
        background: rgba(15, 157, 102, 0.05);
        border: 1px solid rgba(15, 157, 102, 0.1);
        transition: all 0.3s ease;
    }

    .device-item:hover {
        background: rgba(15, 157, 102, 0.1);
        border-color: rgba(15, 157, 102, 0.2);
    }

    .devices-summary {
        max-height: 200px;
        overflow-y: auto;
    }
</style>

<link rel="stylesheet" href="/astracore/pages/css/settings.css">