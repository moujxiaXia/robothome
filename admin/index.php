<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/includes/auth.php';

$pdo = getDb();

// 统计数据
$stmt = $pdo->query('SELECT COUNT(*) FROM articles');
$articleCount = (int)$stmt->fetchColumn();
$stmt = $pdo->query('SELECT COUNT(*) FROM articles WHERE is_published = 1');
$publishedCount = (int)$stmt->fetchColumn();
$stmt = $pdo->query('SELECT COUNT(*) FROM articles WHERE is_published = 0');
$draftCount = (int)$stmt->fetchColumn();

// 最近文章
$stmt = $pdo->query('SELECT a.id, a.title, a.is_published, a.updated_at, c.name as category_name, c.slug as category_slug FROM articles a JOIN categories c ON a.category_id = c.id ORDER BY a.updated_at DESC LIMIT 5');
$recentArticles = $stmt->fetchAll();

// 获取当前主题
$currentTheme = getCurrentTheme();
$themeNames = [
    'default' => '深色科技风',
    'light' => '浅色简洁',
    'bootstrap' => 'Bootstrap 风格'
];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 - 机器人之家</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Noto+Sans+SC:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/style.css')) ?>">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/admin.css')) ?>">
</head>
<body class="admin-body">
    <?php require __DIR__ . '/includes/nav.php'; ?>
    <div class="admin-main">
        <h1 class="admin-page-title">仪表盘</h1>

        <!-- 统计卡片 -->
        <div class="admin-cards">
            <div class="admin-card">
                <div class="admin-card-icon">📝</div>
                <span class="admin-card-num"><?= $articleCount ?></span>
                <span class="admin-card-label">文章总数</span>
                <span class="admin-card-trend">↗ 持续增长</span>
            </div>
            <div class="admin-card">
                <div class="admin-card-icon" style="background: linear-gradient(135deg, rgba(74, 222, 128, 0.15), rgba(34, 197, 94, 0.15));">✅</div>
                <span class="admin-card-num" style="background: linear-gradient(135deg, #4ade80, #22c55e); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?= $publishedCount ?></span>
                <span class="admin-card-label">已发布</span>
                <span class="admin-card-trend" style="color: var(--admin-success); background: rgba(74, 222, 128, 0.1);">↗ 在线展示</span>
            </div>
            <div class="admin-card">
                <div class="admin-card-icon" style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.15), rgba(245, 158, 11, 0.15));">📝</div>
                <span class="admin-card-num" style="background: linear-gradient(135deg, #fbbf24, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?= $draftCount ?></span>
                <span class="admin-card-label">草稿箱</span>
                <span class="admin-card-trend" style="color: var(--admin-warning); background: rgba(251, 191, 36, 0.1);">待完善</span>
            </div>
            <div class="admin-card">
                <div class="admin-card-icon" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(124, 58, 237, 0.15));">🎨</div>
                <span class="admin-card-num" style="font-size: 1.2rem; background: linear-gradient(135deg, #a78bfa, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?= $themeNames[$currentTheme] ?? '默认' ?></span>
                <span class="admin-card-label">当前主题</span>
                <a href="theme.php" class="admin-card-trend" style="text-decoration: none;">更换主题 →</a>
            </div>
        </div>

        <!-- 快捷操作 -->
        <h2 style="font-size: 1.1rem; color: var(--admin-text-muted); margin: 2rem 0 1rem; font-weight: 500;">快捷操作</h2>
        <div class="admin-quick-actions">
            <a href="article-edit.php" class="quick-action-card">
                <div class="quick-action-icon">➕</div>
                <div class="quick-action-content">
                    <h3>新增文章</h3>
                    <p>创建一篇新的博客文章</p>
                </div>
            </a>
            <a href="articles.php" class="quick-action-card">
                <div class="quick-action-icon" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(124, 58, 237, 0.2));">📄</div>
                <div class="quick-action-content">
                    <h3>文章管理</h3>
                    <p>查看和管理所有文章</p>
                </div>
            </a>
            <a href="theme.php" class="quick-action-card">
                <div class="quick-action-icon" style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(245, 158, 11, 0.2));">🎨</div>
                <div class="quick-action-content">
                    <h3>主题设置</h3>
                    <p>切换网站外观风格</p>
                </div>
            </a>
            <a href="../" target="_blank" class="quick-action-card">
                <div class="quick-action-icon" style="background: linear-gradient(135deg, rgba(74, 222, 128, 0.2), rgba(34, 197, 94, 0.2));">🌐</div>
                <div class="quick-action-content">
                    <h3>访问网站</h3>
                    <p>在前台查看网站效果</p>
                </div>
            </a>
        </div>

        <!-- 最近文章 -->
        <h2 style="font-size: 1.1rem; color: var(--admin-text-muted); margin: 2rem 0 1rem; font-weight: 500;">最近更新</h2>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>文章标题</th>
                        <th>栏目</th>
                        <th>状态</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentArticles as $article): ?>
                    <tr>
                        <td><?= e($article['title']) ?></td>
                        <td><?= e($article['category_name']) ?></td>
                        <td>
                            <span class="status-badge <?= $article['is_published'] ? 'published' : 'draft' ?>">
                                <?= $article['is_published'] ? '已发布' : '草稿' ?>
                            </span>
                        </td>
                        <td style="color: var(--admin-text-muted);"><?= e(date('Y-m-d H:i', strtotime($article['updated_at']))) ?></td>
                        <td>
                            <a href="article-edit.php?id=<?= (int)$article['id'] ?>">编辑</a>
                            <a href="../?page=article&cat=<?= e($article['category_slug']) ?>&slug=<?= e($article['slug'] ?? '') ?>" target="_blank">查看</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (empty($recentArticles)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📝</div>
                <p>暂无文章，<a href="article-edit.php">新增一篇</a></p>
            </div>
            <?php endif; ?>
        </div>

        <p class="admin-hint">
            欢迎使用机器人之家管理后台！您可以在这里管理文章、切换主题风格。
        </p>
    </div>
</body>
</html>
