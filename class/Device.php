<?php

class Device {
    public int $id;
    public string $ip;
    public string $localMachineToken;
    public int $userId;

    public function __construct(int $id, string $ip, string $localMachineToken, int $userId) {
        $this->id = $id;
        $this->ip = $ip;
        $this->localMachineToken = $localMachineToken;
        $this->userId = $userId;
    }

    // Convert the device object to an associative array
    public function toArray(): array {
        return [
            'ip' => $this->ip,
            'localMachineToken' => $this->localMachineToken,
        ];
    }
}