<?php
class Database {
    public static function connection(): PDO {
        $path = __DIR__ . '/config.php';
        if (!file_exists($path)) {
            throw new RuntimeException('Copy config.example.php to config.php and set DB credentials.');
        }
        $cfg = require $path;
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $cfg['host'], $cfg['port'], $cfg['database']);
        return new PDO($dsn, $cfg['username'], $cfg['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
