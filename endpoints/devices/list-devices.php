<?php

require_once __DIR__ . '/../../data/save.php';

$devices = getData('devices');
http_response_code(200);
echo json_encode($devices);