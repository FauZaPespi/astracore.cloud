<?php
$start = microtime(true);

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . '/class/utils/Config.php';
require_once __DIR__ . '/class/utils/logger/LogError.php';
require_once __DIR__ . '/class/utils/logger/LogWarning.php';
require_once __DIR__ . '/class/utils/logger/LogInfo.php';
require_once __DIR__ . '/class/utils/logger/LogSuccess.php';
require_once __DIR__ . '/class/utils/logger/LogDebug.php';

// Load config
Config::load(__DIR__ . "/conf.json");
$customPhpError = Config::get("customPhpError", true);
$showErrorPopUp = Config::get("showErrorPopUp", true);


if ($customPhpError) {
    /**
     * Custom error handler
     */
    set_error_handler(function ($severity, $message, $file, $line) use ($showErrorPopUp) {
        if (in_array($severity, [E_WARNING, E_USER_WARNING, E_NOTICE, E_USER_NOTICE])) {
            new LogWarning(
                $message . " in $file:$line",
                "WARNING"
            );
        } else {
            throw new ErrorException($message, 0, $severity, $file, $line);
        }
    });
 
    /**
     * Exception handler
     */
    set_exception_handler(function ($exception) use ($showErrorPopUp) {
        new LogError(
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getCode() != 0 ? $exception->getCode() : "",
            $showErrorPopUp
        );
        //http_response_code(500);
        exit;
    });

    /**
     * Shutdown handler (fatal errors)
     */
    register_shutdown_function(function () use ($showErrorPopUp) {
        $error = error_get_last();
        if ($error && ($error['type'] & (E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR))) {
            new LogError(
                $error['message'],
                $error['file'],
                $error['line'],
                $error['type'],
                $showErrorPopUp
            );
            //http_response_code(500);
            exit;
        }
    });
}

require_once __DIR__ . '/db/Database.php';

define('URL_ROOT', '/astracore');

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Pages
if ($requestUri === URL_ROOT . '/' || $requestUri === URL_ROOT . '/index.php') {
    require_once __DIR__ . '/pages/home.php';
} elseif ($requestUri === URL_ROOT . '/privacy-policy') {
    require_once __DIR__ . '/pages/privacyPolicy.php';
} elseif ($requestUri === URL_ROOT . '/terms-of-use') {
    require_once __DIR__ . '/pages/termsOfUse.php';
} elseif ($requestUri === URL_ROOT . '/doc' || $requestUri === URL_ROOT . '/doc/') {
    require_once __DIR__ . '/pages/documentation.php';
} elseif ($requestUri === URL_ROOT . '/signup') {
    require_once __DIR__ . '/pages/signup.php';
} elseif ($requestUri === URL_ROOT . '/login') {
    require_once __DIR__ . '/pages/login.php';
} elseif ($requestUri === URL_ROOT . '/download?platform=linux') {
    $file = "https://github.com/Res-NeoTech/astracore_receiver/releases/download/Linux/astracore";
    header("Location: $file");
    exit;
} elseif ($requestUri === URL_ROOT . '/download?platform=win') {
    $file = __DIR__ . '/endpoints/download/win/astracore.exe';
    if (file_exists($file)) {
    $file = "https://github.com/Res-NeoTech/astracore_receiver/releases/download/Windows/astracore.exe";
    header("Location: $file");
    exit;
    }
} elseif ($requestUri === URL_ROOT . '/download' || $requestUri === URL_ROOT . '/download/') {
    require_once __DIR__ . '/endpoints/download/download.php';
} elseif (
    $requestUri === URL_ROOT . '/dashboard' ||
    $requestUri === URL_ROOT . '/dashboard/' ||
    strpos($requestUri, URL_ROOT . '/dashboard?tab=') === 0 ||
    strpos($requestUri, URL_ROOT . '/dashboard/?tab=') === 0 ||
    strpos($requestUri, URL_ROOT . '/dashboard?action=') === 0 ||
    strpos($requestUri, URL_ROOT . '/dashboard/?action=') === 0
) {
    require_once __DIR__ . '/pages/dashboard/view.php';
}
// Fallback 404
else {
    http_response_code(404);
    require_once __DIR__ . '/pages/404.php';
    new LogWarning("404 Not Found: " . $requestUri, "HTTP");
}

$end = microtime(true);
require_once 'class/utils/LoggerOscar.php';
new LogInfo('Page generation time: ' . ($end - $start) . ' seconds | Page:' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], 'INFO');
mkdir(__DIR__ . '/class/utils/logger/data', 0777, true);
?>
<base href="/astracore/">
<link rel="stylesheet" href="pages/css/popup.css">
<script src="pages/js/home.js"></script>