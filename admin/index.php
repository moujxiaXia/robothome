<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/includes/auth.php';

$pdo = getDb();
$stmt = $pdo->query('SELECT COUNT(*) FROM articles');
$articleCount = (int)$stmt->fetchColumn();
$stmt = $pdo->query('SELECT COUNT(*) FROM articles WHERE is_published = 1');
$publishedCount = (int)$stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 - 机器人之家</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&family=Noto+Sans+SC:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/style.css')) ?>">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/admin.css')) ?>">
</head>
<body class="admin-body">
    <?php require __DIR__ . '/includes/nav.php'; ?>
    <div class="admin-main">
        <h1 class="admin-page-title">仪表盘</h1>
        <div class="admin-cards">
            <div class="admin-card">
                <span class="admin-card-num"><?= $articleCount ?></span>
                <span class="admin-card-label">文章总数</span>
            </div>
            <div class="admin-card">
                <span class="admin-card-num"><?= $publishedCount ?></span>
                <span class="admin-card-label">已发布</span>
            </div>
        </div>
        <p class="admin-hint"><a href="articles.php">管理文章</a> · <a href="../" target="_blank">查看网站</a></p>
    </div>
</body>
</html>
