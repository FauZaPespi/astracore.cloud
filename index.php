<?php
require_once __DIR__ . '/db/Database.php';

define('URL_ROOT', '/astracore.cloud');

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// API routes
if (strpos($requestUri, URL_ROOT . '/auth/login') !== false) {
    require_once __DIR__ . URL_ROOT . '/endpoints/auth/login.php';
} elseif (strpos($requestUri, '/auth/me') !== false) {
    require_once __DIR__ . '/endpoints/auth/me.php';
} elseif (strpos($requestUri, '/devices/list') !== false) {
    require_once __DIR__ . '/endpoints/devices/list-devices.php';
} elseif (strpos($requestUri, '/devices/add') !== false) {
    require_once __DIR__ . '/endpoints/devices/add-devices.php';
}

// Pages
elseif ($requestUri === URL_ROOT . '/' || $requestUri === URL_ROOT . '/index.php') {
    require_once __DIR__ . '/pages/home.php';
} elseif ($requestUri === URL_ROOT . '/devices') {
    require_once __DIR__ . '/pages/devices.php';
} elseif ($requestUri === URL_ROOT . '/signup') {
    require_once __DIR__ . '/pages/signup.php';
} elseif ($requestUri === URL_ROOT . '/dashboard' || $requestUri === URL_ROOT . '/dashboard/' || strpos($requestUri, URL_ROOT . '/dashboard?tab=') === 0 || strpos($requestUri, URL_ROOT . '/dashboard/?tab=') === 0) {
    require_once __DIR__ . '/pages/dashboard/view.php';
    exit();
}
// Fallback 404
else {
    http_response_code(404);
    require_once __DIR__ . '/pages/404.php';
}
