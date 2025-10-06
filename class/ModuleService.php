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

    // Get the device of a Module
    public static function getDeviceByModule(int $deviceId): array
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

    // Delete a specific module by Id
    public static function deleteModuleById(int $moduleId): bool
    {
        self::init();
        $stmt = self::$db->prepare("DELETE FROM modules WHERE id = :id");
        return $stmt->execute([
            ':id' => $moduleId
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
    public static function getAllModules($userId): array
    {
        self::init();
        $stmt = self::$db->prepare("SELECT m.* FROM modules AS m INNER JOIN devices AS d ON m.device_id = d.id WHERE d.user_id = :user_id;");
        $stmt->execute([':user_id' => $userId]);
        $rows = $stmt->fetchAll();
        $modules = [];
        foreach ($rows as $row) {
            $modules[] = new Module(
                $row['id'],
                $row['device_id'],
                $row['name'],
                $row['description'],
                $row['command'],
                $row['last_executed'] === null ? new DateTime() : new DateTime($row['last_executed']),
                $row['status']
            );
        }
        return $modules;
    }

    // Execute a module (implementation pending)
    public static function execute(int $moduleId): void
    {
        // First update the database lastExecuted
        self::init();
        $stmt = self::$db->prepare("SELECT * FROM modules WHERE id = :id");
        $stmt->execute([':id' => $moduleId]);
        $row = $stmt->fetch();
        if (!$row) {
            throw new Exception("Module not found");
        }
        $now = (new DateTime())->format('Y-m-d H:i:s');
        $stmt = self::$db->prepare("UPDATE modules SET last_executed = :last_executed WHERE id = :id");
        $stmt->execute([
            ':last_executed' => $now,
            ':id' => $moduleId
        ]);
        // Then, call the DeviceService to execute the command on the device


        // TODO: implement execution logic for module identified by $deviceId and $name
    }
}
