<?php

require_once "Device.php";

class User {
    public int $id;
    public string $username;
    public string $password;
    public string $email;
    public array $devices; // Array to hold Device objects

    public function __construct(int $id, string $username, string $password, string $email) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->devices = [];
    }

    // Add a device to the user's device list
    public function addDevice(Device $device): void {
        $this->devices[] = $device;
    }

    // Remove a device from the user's device list
    public function removeDevice($device): void {
        $this->devices = array_filter($this->devices, function($d) use ($device) {
            return $d !== $device;
        });
    }

    // Hash the password
    public function hashPassword(): void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Verify the password
    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->password);
    }

    // Convert the user object to an associative array
    public function toArray(): array {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'devices' => array_map(function($device) {
                return method_exists($device, 'toArray') ? $device->toArray() : $device;
            }, $this->devices),
        ];
    }
}