<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/includes/auth.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    getDb()->prepare('DELETE FROM articles WHERE id = ?')->execute([$id]);
}
header('Location: articles.php');
exit;
