<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/includes/auth.php';

$pdo = getDb();
$categories = getCategories($pdo);
// 后台列表：包括未发布
$stmt = $pdo->query('SELECT a.*, c.name AS category_name FROM articles a JOIN categories c ON a.category_id = c.id ORDER BY a.updated_at DESC');
$articles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文章管理 - 机器人之家</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&family=Noto+Sans+SC:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/style.css')) ?>">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/admin.css')) ?>">
</head>
<body class="admin-body">
    <?php require __DIR__ . '/includes/nav.php'; ?>
    <div class="admin-main">
        <h1 class="admin-page-title">文章管理 <a href="article-edit.php" class="btn btn-primary">新增文章</a></h1>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>标题</th>
                    <th>栏目</th>
                    <th>状态</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $a): ?>
                <tr>
                    <td><?= (int)$a['id'] ?></td>
                    <td><?= e($a['title']) ?></td>
                    <td><?= e($a['category_name']) ?></td>
                    <td><?= $a['is_published'] ? '已发布' : '草稿' ?></td>
                    <td><?= e(date('Y-m-d H:i', strtotime($a['updated_at']))) ?></td>
                    <td>
                        <a href="article-edit.php?id=<?= (int)$a['id'] ?>">编辑</a>
                        <a href="article-delete.php?id=<?= (int)$a['id'] ?>" class="link-danger" onclick="return confirm('确定删除？');">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (empty($articles)): ?><p class="empty-state">暂无文章，<a href="article-edit.php">新增一篇</a></p><?php endif; ?>
    </div>
</body>
</html>
