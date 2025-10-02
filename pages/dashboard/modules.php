<?php
require_once "class/SessionHandler.php";
require_once "class/UserService.php";
require_once "class/ModuleService.php";
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

// Handle module toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'toggle_module') {
        $moduleId = intval($_POST['module_id'] ?? 0);

        if ($moduleId > 0) {
            $result = ModuleService::Execute($moduleId);

            if ($result) {
                $message = "Module status updated successfully!";
                $messageType = 'success';
            } else {
                $message = "Error updating module status.";
                $messageType = 'danger';
            }
        }
    }
}

// Get all modules
$modules = ModuleService::getAllModules();
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
                        <button class="filter-btn active" data-filter="all">
                            <i class="bi bi-grid me-1"></i> All
                        </button>
                        <button class="filter-btn" data-filter="enabled">
                            <i class="bi bi-check-circle me-1"></i> Enabled
                        </button>
                        <button class="filter-btn" data-filter="disabled">
                            <i class="bi bi-x-circle me-1"></i> Disabled
                        </button>
                    </div>
                </div>

                <!-- Modules Grid -->
                <div class="modules-grid" id="modulesGrid">
                    <?php if (!empty($modules)): ?>
                        <?php foreach ($modules as $module): ?>
                            <div class="module-widget <?= $module->enabled ? 'enabled' : 'disabled' ?>"
                                data-module-id="<?= $module->id ?>"
                                data-status="<?= $module->enabled ? 'enabled' : 'disabled' ?>"
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
                                </div>

                                <div class="module-footer">
                                    <div class="module-status">
                                        <span class="status-dot <?= $module->enabled ? 'active' : 'inactive' ?>"></span>
                                        <span class="status-text"><?= $module->enabled ? 'Enabled' : 'Disabled' ?></span>
                                    </div>

                                    <form method="POST" class="module-toggle-form">
                                        <input type="hidden" name="action" value="toggle_module">
                                        <input type="hidden" name="module_id" value="<?= $module->id ?>">
                                        <button type="submit" class="toggle-btn <?= $module->enabled ? 'btn-disable' : 'btn-enable' ?>"
                                            data-toggle="tooltip" title="<?= $module->enabled ? 'Disable module' : 'Enable module' ?>">
                                            <i class="bi bi-<?= $module->enabled ? 'toggle-on' : 'toggle-off' ?>"></i>
                                        </button>
                                    </form>
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
                                    <?php else: ?>
                                        <div class="alert alert-warning" role="alert">
                                            You need to <a href="dashboard/?tab=devices-add" class="alert-link">add a device</a> before creating modules.
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

<script src="/astracore/pages/js/modules.js"></script>
<link rel="stylesheet" href="/astracore/pages/css/modules.css">
<link rel="stylesheet" href="/astracore/pages/css/settings.css">