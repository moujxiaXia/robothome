<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/includes/auth.php';

$pdo = getDb();
$categories = getCategories($pdo);

// 获取筛选参数
$filterCategory = $_GET['category'] ?? '';
$filterStatus = $_GET['status'] ?? '';

// 构建查询
$sql = 'SELECT a.*, c.name AS category_name, c.slug AS category_slug FROM articles a JOIN categories c ON a.category_id = c.id WHERE 1=1';
$params = [];

if ($filterCategory !== '') {
    $sql .= ' AND c.slug = ?';
    $params[] = $filterCategory;
}

if ($filterStatus !== '') {
    $sql .= ' AND a.is_published = ?';
    $params[] = ($filterStatus === 'published') ? 1 : 0;
}

$sql .= ' ORDER BY a.updated_at DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$articles = $stmt->fetchAll();

// 统计数据
$totalCount = count($articles);
$publishedCount = count(array_filter($articles, fn($a) => $a['is_published'] == 1));
$draftCount = $totalCount - $publishedCount;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文章管理 - 机器人之家</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Noto+Sans+SC:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/style.css')) ?>">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/admin.css')) ?>">
</head>
<body class="admin-body">
    <?php require __DIR__ . '/includes/nav.php'; ?>
    <div class="admin-main">
        <h1 class="admin-page-title">
            文章管理
            <a href="article-edit.php" class="btn btn-primary">
                <span>➕</span> 新增文章
            </a>
        </h1>

        <!-- 统计卡片 -->
        <div class="admin-cards" style="grid-template-columns: repeat(3, 1fr);">
            <div class="admin-card">
                <div class="admin-card-icon">📊</div>
                <span class="admin-card-num"><?= $totalCount ?></span>
                <span class="admin-card-label">全部文章</span>
            </div>
            <div class="admin-card">
                <div class="admin-card-icon" style="background: linear-gradient(135deg, rgba(74, 222, 128, 0.15), rgba(34, 197, 94, 0.15));">✅</div>
                <span class="admin-card-num" style="background: linear-gradient(135deg, #4ade80, #22c55e); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?= $publishedCount ?></span>
                <span class="admin-card-label">已发布</span>
            </div>
            <div class="admin-card">
                <div class="admin-card-icon" style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.15), rgba(245, 158, 11, 0.15));">📝</div>
                <span class="admin-card-num" style="background: linear-gradient(135deg, #fbbf24, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?= $draftCount ?></span>
                <span class="admin-card-label">草稿</span>
            </div>
        </div>

        <!-- 筛选器 -->
        <div style="background: var(--admin-bg-card); border: 1px solid var(--admin-border); border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">
            <span style="color: var(--admin-text-muted); font-size: 0.9rem;">🔍 筛选：</span>
            <form method="get" style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; flex: 1;">
                <select name="category" style="padding: 0.5rem 0.75rem; background: var(--admin-bg); border: 1px solid var(--admin-border); border-radius: 8px; color: var(--admin-text); font-size: 0.9rem;">
                    <option value="">所有栏目</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= e($cat['slug']) ?>" <?= $filterCategory === $cat['slug'] ? 'selected' : '' ?>>
                        <?= e($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <select name="status" style="padding: 0.5rem 0.75rem; background: var(--admin-bg); border: 1px solid var(--admin-border); border-radius: 8px; color: var(--admin-text); font-size: 0.9rem;">
                    <option value="">所有状态</option>
                    <option value="published" <?= $filterStatus === 'published' ? 'selected' : '' ?>>已发布</option>
                    <option value="draft" <?= $filterStatus === 'draft' ? 'selected' : '' ?>>草稿</option>
                </select>
                <button type="submit" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;">应用筛选</button>
                <?php if ($filterCategory || $filterStatus): ?>
                <a href="articles.php" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;">清除筛选</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- 文章列表 -->
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>文章标题</th>
                        <th style="width: 100px;">栏目</th>
                        <th style="width: 100px;">状态</th>
                        <th style="width: 140px;">更新时间</th>
                        <th style="width: 140px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $a): ?>
                    <tr>
                        <td style="color: var(--admin-text-muted); font-family: monospace;"><?= (int)$a['id'] ?></td>
                        <td>
                            <div style="font-weight: 500;"><?= e($a['title']) ?></div>
                            <?php if ($a['slug']): ?>
                            <div style="font-size: 0.8rem; color: var(--admin-text-muted); margin-top: 0.25rem;">/<?= e($a['category_slug']) ?>/<?= e($a['slug']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.375rem 0.75rem; background: rgba(56, 189, 248, 0.1); color: var(--admin-accent); border-radius: 6px; font-size: 0.8rem;">
                                <?= e($a['category_name']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="status-badge <?= $a['is_published'] ? 'published' : 'draft' ?>">
                                <?= $a['is_published'] ? '已发布' : '草稿' ?>
                            </span>
                        </td>
                        <td style="color: var(--admin-text-muted); font-size: 0.85rem;">
                            <?= e(date('Y-m-d H:i', strtotime($a['updated_at']))) ?>
                        </td>
                        <td>
                            <a href="article-edit.php?id=<?= (int)$a['id'] ?>">✏️ 编辑</a>
                            <?php if ($a['is_published'] && $a['slug']): ?>
                            <a href="../?page=article&cat=<?= e($a['category_slug']) ?>&slug=<?= e($a['slug']) ?>" target="_blank">👁️ 查看</a>
                            <?php endif; ?>
                            <a href="article-delete.php?id=<?= (int)$a['id'] ?>" class="link-danger" onclick="return confirm('确定删除这篇文章吗？此操作不可恢复。');">🗑️ 删除</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (empty($articles)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📝</div>
                <p style="font-size: 1.1rem; margin-bottom: 0.5rem;">暂无文章</p>
                <p style="font-size: 0.9rem;"><?= ($filterCategory || $filterStatus) ? '尝试清除筛选条件' : '<a href="article-edit.php">新增一篇文章</a>开始创作' ?></p>
            </div>
            <?php endif; ?>
        </div>

        <p class="admin-hint">
            💡 提示：点击文章标题可以编辑，已发布的文章可以点击查看前台效果。
        </p>
    </div>
</body>
</html>
