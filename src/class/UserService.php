<?php
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/User.php';
class UserService
{
    private static \PDO $db;

    private static function init()
    {
        if (!isset(self::$db)) {
            self::$db = Database::getInstance()->getConnection();
        }
    }

    public static function getAllUser() : array
    {
        self::init();
        $stmt = self::$db->prepare("SELECT id, username, email, role FROM users");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }

    // Check for taken credentials.
    public static function checkForExistantCredentials(string $username, string $email): int
    {
        self::init();
        define("AVAILABLE", 0);
        define("USERNAME_TAKEN", 1);
        define("EMAIL_TAKEN", 2);
        define("UKNOWN_ERROR", 3);

        $stmt = self::$db->prepare("SELECT username, email FROM users WHERE username = :username OR email = :email");

        if ($stmt->execute([
            ':username' => $username,
            ':email' => $email
        ])) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ($user['username'] === $username) {
                    return USERNAME_TAKEN;
                } else if ($user['email'] === $email) {
                    return EMAIL_TAKEN;
                }
            } else {
                return AVAILABLE;
            }
        }

        return UKNOWN_ERROR;
    }

    // Create a new user
    public static function createUser(string $username, string $password, string $email): ?User
    {
        $defaultRole = "member";
        self::init();
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
        $stmt = self::$db->prepare("INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)");

        if ($stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword,
            ':email' => $email,
            ':role' => $defaultRole
        ])) {

            $id = (int)self::$db->lastInsertId();
            $tmp = UserRole::tryFrom($defaultRole) ?? UserRole::Member;
            return new User($id, $username, $hashedPassword, $email, $tmp);
        }

        return null;
    }

    // Edit an existing user
    public static function editUser(int $id, ?string $username = null, ?string $password = null, ?string $email = null): ?User
    {
        self::init();
        $fields = [];
        $params = [':id' => $id];

        if ($username !== null) {
            $fields[] = "username = :username";
            $params[':username'] = $username;
        }
        if ($password !== null) {
            $fields[] = "password = :password";
            $params[':password'] = password_hash($password, PASSWORD_ARGON2ID);
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
    public static function getUserById(int $id): ?User
    {
        self::init();
        $stmt = self::$db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $userData = $stmt->fetch();

        if (!$userData) return null;

        $enumRole = UserRole::tryFrom($userData['role']) ?? UserRole::Member;
        
        $user = new User(
            $userData['id'],
            $userData['username'],
            $userData['password'],
            $userData['email'],
            $enumRole
        );
        $user->devices = [];
        // Fetch devices
        $stmtDevices = self::$db->prepare("SELECT * FROM devices WHERE user_id = :user_id");
        $stmtDevices->execute([':user_id' => $id]);
        $devices = $stmtDevices->fetchAll();

        foreach ($devices as $deviceData) {
            $device = new Device($deviceData['id'], $deviceData['ip'], $deviceData['token'], $id);
            $user->addDevice($device);
        } 

        return $user;
    }

    /**
     * Fonction pour supprimer un user
     * @param int idUser pour choisir l'user à suppirimer
     * @return bool si la suppréssion c'est bien réaliser
     */
    public static function deleteUser(int $idUser) : bool
    {
        self::init();
        $stmt = self::$db->prepare("DELETE FROM users WHERE id = ?");
        $result = $stmt->execute([$idUser]);
        return $result;
    }

    // Login user
    public static function login(string $usernameOrEmail, string $password): ?User
    {
        self::init();
        $stmt = self::$db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->execute([
            ':username' => $usernameOrEmail,
            ':email' => $usernameOrEmail
        ]);
        $userData = $stmt->fetch();

        if ($userData && password_verify($password, $userData['password'])) {
            return self::getUserById((int)$userData['id']);
        }

        return null;
    }

    // Generate a new token for user
    public static function generateToken(int $userId): ?string
    {
        self::init();
        $token = bin2hex(random_bytes(32)); // 64-character token
        $stmt = self::$db->prepare("UPDATE users SET token = :token WHERE id = :id");
        if ($stmt->execute([':token' => $token, ':id' => $userId])) {
            return $token;
        }
        return null;
    }

    /*
    // Get user by token
    public static function getUserByToken(string $token): ?User
    {
        self::init();
        $stmt = self::$db->prepare("SELECT * FROM users WHERE token = :token");
        $stmt->execute([':token' => $token]);
        $userData = $stmt->fetch();

        if (!$userData) return null;

        return self::getUserById((int)$userData['id']);
    }
    */

    // Logout user (remove token)
    public static function logout(int $userId): bool
    {
        self::init();
        $stmt = self::$db->prepare("UPDATE users SET token = NULL WHERE id = :id");
        return $stmt->execute([':id' => $userId]);
    }
}