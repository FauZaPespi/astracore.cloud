<?php

// filepath: Z:/MAMP/htdocs/astracore.cloud/api/class/Device.php

class Device {
    private string $ip;
    private int $port;
    private string $localMachineToken;

    public function __construct(string $ip, int $port, string $localMachineToken) {
        $this->ip = $ip;
        $this->port = $port;
        $this->localMachineToken = $localMachineToken;
    }

    // Getters
    public function getIp(): string {
        return $this->ip;
    }

    public function getPort(): int {
        return $this->port;
    }

    public function getLocalMachineToken(): string {
        return $this->localMachineToken;
    }

    // Setters
    public function setIp(string $ip): void {
        $this->ip = $ip;
    }

    public function setPort(int $port): void {
        $this->port = $port;
    }

    public function setLocalMachineToken(string $localMachineToken): void {
        $this->localMachineToken = $localMachineToken;
    }

    // Convert the device object to an associative array
    public function toArray(): array {
        return [
            'ip' => $this->ip,
            'port' => $this->port,
            'localMachineToken' => $this->localMachineToken,
        ];
    }
}