<?php
class Config {
    private static array $config = [];

    public static function load(string $file = __DIR__ . "/../conf.json"): void {
        if (!file_exists($file)) {
            throw new Exception("Config file not found: $file");
        }
        $json = file_get_contents($file);
        self::$config = json_decode($json, true);
        if (self::$config === null) {
            throw new Exception("Invalid JSON in $file");
        }
    }

    public static function get(string $key, $default = null) {
        return self::$config[$key] ?? $default;
    }
}
