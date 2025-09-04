<?php

require_once __DIR__ . '/../../data/save.php';

// For simplicity, assume the user is already authenticated
// In a real-world scenario, you would use tokens or sessions
http_response_code(200);
echo json_encode(['message' => 'User details']);