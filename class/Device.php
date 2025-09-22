<?php

// filepath: Z:/MAMP/htdocs/astracore.cloud/api/class/Device.php

class Device {
    private string $ip;
    private string $localMachineToken;

    public function __construct(string $ip, string $localMachineToken) {
        $this->ip = $ip;
        $this->localMachineToken = $localMachineToken;
    }

    // Getters
    public function getIp(): string {
        return $this->ip;
    }

    public function getLocalMachineToken(): string {
        return $this->localMachineToken;
    }

    // Setters
    public function setIp(string $ip): void {
        $this->ip = $ip;
    }

    public function setLocalMachineToken(string $localMachineToken): void {
        $this->localMachineToken = $localMachineToken;
    }

    // Convert the device object to an associative array
    public function toArray(): array {
        return [
            'ip' => $this->ip,
            'localMachineToken' => $this->localMachineToken,
        ];
    }
}