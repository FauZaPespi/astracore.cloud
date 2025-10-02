<?php
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/Module.php';

class ModuleService
{
    private static \PDO $db;

    private static function init()
    {
        if (!isset(self::$db)) {
            self::$db = Database::getInstance()->getConnection();
        }
    }

    public static function isAlreadyAdded(int $deviceId, string $name): bool
    {
        self::init();

        $stmt = self::$db->prepare("SELECT id FROM modules WHERE device_id = :device_id AND name = :name");
        $stmt->bindParam(":device_id", $deviceId, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public static function addModule(
        int $deviceId,
        string $name,
        string $description,
        string $command,
        string $status
    ): Module | null {
        self::init();

        $stmt = self::$db->prepare(
            "INSERT INTO modules (device_id, name, description, command, status) VALUES (:device_id, :name, :description, :command, :status)"
        );
        $stmt->bindParam(":device_id", $deviceId, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":command", $command, PDO::PARAM_STR);
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $id = (int)self::$db->lastInsertId();
            return new Module($id, $deviceId, $name, $description, $command, new DateTime(), $status);
        } else {
            return null;
        }
    }

    // Get all modules for a device
    public static function getModulesByDeviceId(int $deviceId): array
    {
        self::init();
        $stmt = self::$db->prepare("SELECT * FROM modules WHERE device_id = :device_id");
        $stmt->execute([':device_id' => $deviceId]);
        $rows = $stmt->fetchAll();

        $modules = [];
        foreach ($rows as $row) {
            $modules[] = new Module(
                $row['id'],
                $row['device_id'],
                $row['name'],
                $row['description'],
                $row['command'],
                $row['last_executed'],
                $row['status']
            );
        }
        return $modules;
    }

    // Delete a specific module
    public static function deleteModule(int $deviceId, string $name): bool
    {
        self::init();
        $stmt = self::$db->prepare("DELETE FROM modules WHERE device_id = :device_id AND name = :name");
        return $stmt->execute([
            ':device_id' => $deviceId,
            ':name' => $name
        ]);
    }

    // Delete all modules for a device
    public static function clearModulesForDevice(int $deviceId): bool
    {
        self::init();
        $stmt = self::$db->prepare("DELETE FROM modules WHERE device_id = :device_id");
        return $stmt->execute([':device_id' => $deviceId]);
    }
    // List all modules across all devices
    public static function getAllModules(): array
    {
        self::init();
        $stmt = self::$db->query("SELECT * FROM modules");
        $rows = $stmt->fetchAll();

        $modules = [];
        foreach ($rows as $row) {
            $modules[] = new Module(
                $row['id'],
                $row['device_id'],
                $row['name'],
                $row['description'],
                $row['command'],
                $row['last_executed'],
                $row['status']
            );
        }
        return $modules;
    }

    // Execute a module (implementation pending)
    public static function execute(int $moduleId): void
    {
        // TODO: implement execution logic for module identified by $deviceId and $name
    }
}
