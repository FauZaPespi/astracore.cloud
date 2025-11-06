<?php
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/Device.php';

class DeviceService
{
    private static \PDO $db;

    private static function init()
    {
        if (!isset(self::$db)) {
            self::$db = Database::getInstance()->getConnection();
        }
    }

    public static function isAlreadyAdded(string $ip): bool
    {
        self::init();

        $stmt = self::$db->prepare("SELECT id FROM devices WHERE ip = :ip");
        $stmt->bindParam(":ip", $ip, PDO::PARAM_STR);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function addDevice(string $ip, string $token, int $userId): Device | null
    {
        self::init();

        $stmt = self::$db->prepare("INSERT INTO devices (ip, token, user_id) VALUES (:ip, :token, :user_id)");
        $stmt->bindParam(":ip", $ip, PDO::PARAM_INT);
        $stmt->bindParam(":token", $token, PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $id = (int)self::$db->lastInsertId();
            return new Device($id, $ip, $token, $userId);
        } else {
            return null;
        }
    }

    // Récupère tous les devices liés à un user
    public static function getDevicesByUserId(int $userId): array
    {
        self::init();
        $stmt = self::$db->prepare("SELECT * FROM devices WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        $rows = $stmt->fetchAll();

        $devices = [];
        foreach ($rows as $row) {
            $devices[] = new Device($row['id'], $row['ip'], $row['local_machine_token'], $userId);
        }
        return $devices;
    }
    // Récupère tous les devices liés à un user
    public static function getDeviceById(int $id): Device | null
    {
        self::init();
        $stmt = self::$db->prepare("SELECT * FROM devices WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $arrDevice = $stmt->fetch();
        return new Device($arrDevice['id'], $arrDevice['ip'], $arrDevice['token'], $id);
    }

    // Supprime un device spécifique
    public static function deleteDevice(int $userId, string $localMachineToken): bool
    {
        self::init();
        $stmt = self::$db->prepare("DELETE FROM devices WHERE user_id = :user_id AND token = :token");
        return $stmt->execute([
            ':user_id' => $userId,
            ':token' => $localMachineToken
        ]);
    }

    // Supprime tous les devices liés à un user
    public static function clearDevicesForUser(int $userId): bool
    {
        self::init();
        $stmt = self::$db->prepare("DELETE FROM devices WHERE user_id = :user_id");
        return $stmt->execute([':user_id' => $userId]);
    }
}
