<?php
session_start();
require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/DeviceService.php";
require_once "class/ModuleService.php";
require_once "class/utils/popUp/PopUpNotification.php";
$user = null;
if (isset($_SESSION["userId"])) {
    $user = UserService::getUserById($_SESSION["userId"]);
    $isLogged = !empty($user);
}

$message = '';
$messageType = '';
$reponseAPI = '';

// Handle module toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'execute_module') {
        $moduleId = intval($_POST['module_id'] ?? 0);

        if ($moduleId > 0) {
            $result = ModuleService::Execute($moduleId);
            $reponseAPI = $result;

            if ($result) {
                $message = "Module status updated successfully!";
                $messageType = 'success';
            } else {
                $message = "Error updating module status.";
                $messageType = 'danger';
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_module') {
        $moduleId = intval($_POST['module_id'] ?? 0);

        if ($moduleId > 0) {
            $result = ModuleService::deleteModuleById($moduleId);

            if ($result) {
                $message = "Module deleted successfully!";
                $messageType = 'success';
            } else {
                $message = "Error deleting module.";
                $messageType = 'danger';
            }
        }
    }
?>
    <script>
        // Redirect to the same page to avoid form resubmission
        setTimeout(() => {
            if (localStorage.getItem('reloadedRecently') === 'true') {
                localStorage.setItem('reloadedRecently', 'false');
                console.log("Already reloaded recently, not reloading again.");
                return;
            };
            <?php header("Location: /dashboard/?tab=modules-list"); ?>
            window.location.reload(true);

            localStorage.setItem('reloadedRecently', 'true');
        }, 100);
    </script>
<?php
} else {
?>
    <script>
        // Redirect to the same page to avoid form resubmission
        setTimeout(() => {
            localStorage.setItem('reloadedRecently', 'false');
        }, 100);
    </script>
<?php
}

// Get all modules
$modules = ModuleService::getAllModules($user->id);
?>

<main class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-header mb-4">
                    <h1 class="page-title">
                        <i class="bi bi-grid-3x3-gap me-2"></i>
                        Modules Dashboard
                    </h1>
                    <p class="page-description">Manage and configure your AstraCore modules</p>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Search and Filter Bar -->
                <div class="modules-toolbar mb-4">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="moduleSearch" placeholder="Search modules..." class="search-input">
                    </div>
                    <div class="filter-buttons">
                        <?php if (!empty($user->devices)): ?>
                            <div class="mb-3">

                                <select class="form-select device-filter" id="deviceSelect" name="devuceId" required>
                                    <option value="all">All</option>
                                    <?php foreach ($user->devices as $device): ?>
                                        <option value="<?= $device->ip ?>">
                                            <?= htmlspecialchars($device->ip) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <div class="alert" role="alert">
                                You need to <a href="dashboard/?tab=devices-add" class="alert-link">add a device</a> before creating modules.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Modules Grid -->
                <div class="modules-grid" id="modulesGrid">
                    <?php if (!empty($modules)): ?>
                        <?php foreach ($modules as $module): ?>
                            <?php
                            $device = DeviceService::getDeviceById($module->deviceId);
                            $ip = $device ? $device->ip : 'Unknown';
                            ?>
                            <div class="module-widget"
                                data-module-id="<?= $module->id ?>"
                                data-device="<?= $ip ?>"
                                draggable="true">
                                <div class="module-header">
                                    <div class="module-icon">
                                        <i class="bi bi-puzzle"></i>
                                    </div>
                                    <div class="module-drag-handle">
                                        <i class="bi bi-grip-vertical"></i>
                                    </div>
                                </div>

                                <div class="module-body">
                                    <h3 class="module-title"><?= htmlspecialchars($module->name) ?></h3>
                                    <p class="module-description"><?= htmlspecialchars($module->description) ?></p>
                                    <div class="module-status">
                                        <span class="status-text text-secondary">IP:</span>
                                        <span class="status-text text-success" data-toggle="tooltip" title="<?= $ip ?>"><?= str_repeat("*", strlen(htmlspecialchars(substr($ip, 0, 255))))  ?></span>
                                    </div>
                                </div>
                                <div class="module-footer">
                                    <div class="module-status">
                                        <span class="status-text text-secondary">Last time executed:</span>
                                        <span class="status-text text-success" data-toggle="tooltip" title="<?= $module->lastExecuted->format('Y-m-d') ?>"><?= $module->lastExecuted->format('H:i:s') ?></span>
                                    </div>

                                    <div class="module-actions">
                                        <button id="readCommand" class="btn-popUp"
                                            data-toggle="tooltip" title="Read information" data-title="<?= htmlspecialchars($module->name)?>" data-command="<?= htmlspecialchars($module->command) ?>" data-history="<?= base64_encode(ModuleService::getLastConsoleOutputs($module->id) . "") ?>"><i class="bi bi-body-text"></i></button>
                                        <form method="POST" class="module-toggle-form">
                                            <input type="hidden" name="action" value="delete_module">
                                            <input type="hidden" name="module_id" value="<?= $module->id ?>">
                                            <button type="submit" class="toggle-btn"
                                                data-toggle="tooltip" title="Delete Module">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                        <form method="POST" class="module-toggle-form">
                                            <input type="hidden" name="action" value="execute_module">
                                            <input type="hidden" name="module_id" value="<?= $module->id ?>">
                                            <button type="submit" class="toggle-btn"
                                                data-toggle="tooltip" title="Execute Module">
                                                <i class="bi bi-terminal"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-modules">
                            <i class="bi bi-inbox"></i>
                            <h3>No Modules Available</h3>
                            <p>There are no modules installed yet.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- New Module Form Card -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Create New Module
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <input type="hidden" name="action" value="create_module">
                                    <?php if (!empty($user->devices)): ?>
                                        <div class="mb-3">
                                            <label for="deviceSelect" class="form-label">Select Device</label>
                                            <select class="form-select" id="deviceSelect" name="devuceId" required>
                                                <?php foreach ($user->devices as $device): ?>
                                                    <option value="<?= $device->id ?>">
                                                        <?= htmlspecialchars($device->ip) ?> (Token: <?= str_repeat("*", strlen(htmlspecialchars(substr($device->localMachineToken, 0, 255))))  ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mb-3">
                                        <label for="moduleName" class="form-label">Module Name</label>
                                        <input type="text" class="form-control" id="moduleName" name="module_name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="moduleDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="moduleDescription" name="module_description" rows="3" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="moduleCommand" class="form-label">Command</label>
                                        <input type="text" class="form-control" id="moduleCommand" name="module_command" value='echo "Hello, World!"' required>
                                        <div class="form-text">The command that will be executed by the module. <span class="text-warning opacity-75">(Ensure this is a valid command. We are not responsible for any actions or consequences resulting from its execution.)</span></div>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="moduleEnabled" name="module_enabled" checked>
                                        <label class="form-check-label text-secondary" for="moduleEnabled">
                                            Enable module after creation
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus-lg me-2"></i>Create Module
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br style="user-select: none;">
                <br style="user-select: none;">
                <?php
                // Handle module creation
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_module') {
                    if (!empty($user->devices)) {
                        $deviceId = trim($_POST['devuceId'] ?? 0);
                        $moduleName = trim($_POST['module_name'] ?? 'Unamed Module');
                        $moduleDescription = trim($_POST['module_description'] ?? 'No description provided.');
                        $moduleCommand = trim($_POST['module_command'] ?? 'echo "Hello, World!"');
                        $moduleEnabled = trim($_POST['module_enabled']);

                        if (!empty($moduleName) && !empty($moduleDescription)) {
                            $result = ModuleService::addModule($deviceId, $moduleName, $moduleDescription, $moduleCommand, $moduleEnabled);

                            if ($result) {
                                $message = "Module created successfully!";
                                $messageType = 'success';
                            } else {
                                $message = "Error creating module.";
                                $messageType = 'danger';
                            }

                            // Refresh the page to show the new module
                            header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode($message) . "&type=" . $messageType);
                            exit();
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</main>
<script src="/pages/js/modules.js"></script>
<script src="/pages/js/smallPopUp.js"></script>
<link rel="stylesheet" href="/pages/css/dashboard/modules.css">
<link rel="stylesheet" href="/pages/css/dashboard/settings.css">
<link rel="stylesheet" href="/pages/css/utils/forms.css">
