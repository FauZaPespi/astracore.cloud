<?php

require_once __DIR__ . '/../../class/UserService.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['username']) || !isset($input['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Username and password are required']);
    exit;
}

// Attempt to login the user
$user = UserService::login($input['username'], $input['password']);

if ($user === null) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid credentials']);
    exit;
}

// Generate a new token
$token = UserService::generateToken($user->getId());
if ($token === null) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to generate token']);
    exit;
}

// Refresh the user object with the new token
$user = UserService::getUserById($user->getId());

http_response_code(200);
echo json_encode([
    'message' => 'Login successful',
    'user' => $user->toArray() // returns id, username, email, token, devices
]);
