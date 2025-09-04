<?php
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/User.php';
class UserService {
    private static \PDO $db;

    private static function init() {
        if (!isset(self::$db)) {
            self::$db = Database::getInstance()->getConnection();
        }
    }

    // Create a new user
    public static function createUser(string $username, string $password, string $email): ?User {
        self::init();
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = self::$db->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");

        if ($stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword,
            ':email' => $email,
        ])) {
            $id = (int)self::$db->lastInsertId();
            return new User($id, $username, $hashedPassword, $email);
        }

        return null;
    }

    // Edit an existing user
    public static function editUser(int $id, ?string $username = null, ?string $password = null, ?string $email = null): ?User {
        self::init();
        $fields = [];
        $params = [':id' => $id];

        if ($username !== null) {
            $fields[] = "username = :username";
            $params[':username'] = $username;
        }
        if ($password !== null) {
            $fields[] = "password = :password";
            $params[':password'] = password_hash($password, PASSWORD_BCRYPT);
        }
        if ($email !== null) {
            $fields[] = "email = :email";
            $params[':email'] = $email;
        }

        if (empty($fields)) return null;

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = self::$db->prepare($sql);

        if ($stmt->execute($params)) {
            return self::getUserById($id);
        }

        return null;
    }

    // Get user by ID
    public static function getUserById(int $id): ?User {
        self::init();
        $stmt = self::$db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $userData = $stmt->fetch();

        if (!$userData) return null;

        $user = new User(
            $userData['id'],
            $userData['username'],
            $userData['password'],
            $userData['email'],
            $userData['token'] ?? ''
        );

        // Fetch devices
        $stmtDevices = self::$db->prepare("SELECT * FROM devices WHERE user_id = :user_id");
        $stmtDevices->execute([':user_id' => $id]);
        $devices = $stmtDevices->fetchAll();

        foreach ($devices as $deviceData) {
            $device = new Device($deviceData['ip'], $deviceData['port'], $deviceData['local_machine_token']);
            $user->addDevice($device);
        }

        return $user;
    }

    // Login user
    public static function login(string $usernameOrEmail, string $password): ?User {
        self::init();
        $stmt = self::$db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->execute([
            ':username' => $usernameOrEmail,
            ':email' => $usernameOrEmail
        ]);
        $userData = $stmt->fetch();
        echo $userData['password'];
        echo "\n";
        echo $password;
        
        if ($userData && password_verify($password, $userData['password'])) {
            return self::getUserById((int)$userData['id']);
        }
    
        return null;
    }
    

    // Generate a new token for user
    public static function generateToken(int $userId): ?string {
        self::init();
        $token = bin2hex(random_bytes(32)); // 64-character token
        $stmt = self::$db->prepare("UPDATE users SET token = :token WHERE id = :id");
        if ($stmt->execute([':token' => $token, ':id' => $userId])) {
            return $token;
        }
        return null;
    }

    // Get user by token
    public static function getUserByToken(string $token): ?User {
        self::init();
        $stmt = self::$db->prepare("SELECT * FROM users WHERE token = :token");
        $stmt->execute([':token' => $token]);
        $userData = $stmt->fetch();

        if (!$userData) return null;

        return self::getUserById((int)$userData['id']);
    }

    // Logout user (remove token)
    public static function logout(int $userId): bool {
        self::init();
        $stmt = self::$db->prepare("UPDATE users SET token = NULL WHERE id = :id");
        return $stmt->execute([':id' => $userId]);
    }
}
