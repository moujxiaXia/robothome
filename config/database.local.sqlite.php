<?php
// 本地无 MySQL 时使用：复制为 database.local.php 即可用 SQLite 运行
// 或保留本文件，并在 database.php 中取消“仅当无 database.local.php 时加载”的注释
define('DB_DRIVER', 'sqlite');
define('DB_NAME', 'robothome');
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
define('BASE_PATH', '');
