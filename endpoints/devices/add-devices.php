<?php

require_once __DIR__ . '/../../data/save.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['device_name'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Device name is required']);
    exit;
}

saveData('devices', ['device_name' => $input['device_name']]);
http_response_code(201);
echo json_encode(['message' => 'Device added successfully']);