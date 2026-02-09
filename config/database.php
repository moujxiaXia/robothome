<?php
/**
 * 数据库配置 - 机器人之家
 * 本地可复制为 database.local.php 并修改（该文件已 gitignore）
 */
if (file_exists(__DIR__ . '/database.local.php')) {
    require __DIR__ . '/database.local.php';
} elseif (file_exists(__DIR__ . '/database.local.sqlite.php')) {
    require __DIR__ . '/database.local.sqlite.php';
}
if (!defined('DB_DRIVER')) define('DB_DRIVER', getenv('DB_DRIVER') ?: 'mysql');
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'robothome');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'robothome');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') ?: 'your_password');
if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8mb4');
if (!defined('BASE_PATH')) define('BASE_PATH', getenv('BASE_PATH') ?: '');

function getDb(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        if (DB_DRIVER === 'sqlite') {
            $dataDir = dirname(__DIR__) . '/data';
            if (!is_dir($dataDir)) {
                @mkdir($dataDir, 0755, true);
            }
            $path = $dataDir . '/' . (DB_NAME ?: 'robothome') . '.sqlite';
            $pdo = new PDO('sqlite:' . $path, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            _ensureSqliteSchema($pdo, dirname(__DIR__) . '/sql/schema_sqlite.sql');
        } else {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
    }
    return $pdo;
}

function _ensureSqliteSchema(PDO $pdo, string $schemaPath): void {
    $check = $pdo->query("SELECT 1 FROM sqlite_master WHERE type='table' AND name='categories'");
    if ($check && $check->fetch()) {
        return;
    }
    if (is_file($schemaPath)) {
        $sql = file_get_contents($schemaPath);
        $pdo->exec($sql);
    }
}
