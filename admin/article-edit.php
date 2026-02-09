<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/includes/auth.php';

$pdo = getDb();
$categories = getCategories($pdo);
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article = null;
if ($id > 0) {
    $article = getArticleById($pdo, $id);
    if (!$article) {
        header('Location: articles.php');
        exit;
    }
}

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $summary = trim($_POST['summary'] ?? '');
    $content = $_POST['content'] ?? '';
    $isPublished = isset($_POST['is_published']) ? 1 : 0;

    if ($title === '') {
        $err = '请填写标题';
    } elseif ($slug === '') {
        $slug = preg_replace('/\s+/', '-', $title);
        $slug = preg_replace('/[^\p{L}\p{N}-]/u', '', $slug) ?: 'post-' . time();
    } elseif ($categoryId <= 0) {
        $err = '请选择栏目';
    } else {
        $coverImage = $article['cover_image'] ?? null;
        if (!empty($_FILES['cover_image']['tmp_name']) && is_uploaded_file($_FILES['cover_image']['tmp_name'])) {
            $dir = dirname(__DIR__) . '/uploads';
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $ext = strtolower(pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
                $name = date('Ymd') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $dir . '/' . $name)) {
                    $coverImage = $name;
                }
            }
        }

        try {
            $updatedAt = date('Y-m-d H:i:s');
            if ($id > 0) {
                $stmt = $pdo->prepare('UPDATE articles SET category_id=?, title=?, slug=?, summary=?, content=?, cover_image=?, is_published=?, updated_at=? WHERE id=?');
                $stmt->execute([$categoryId, $title, $slug, $summary, $content, $coverImage, $isPublished, $updatedAt, $id]);
                $msg = '已更新';
            } else {
                $stmt = $pdo->prepare('INSERT INTO articles (category_id, title, slug, summary, content, cover_image, is_published) VALUES (?,?,?,?,?,?,?)');
                $stmt->execute([$categoryId, $title, $slug, $summary, $content, $coverImage, $isPublished]);
                $msg = '已发布';
            }
            header('Location: articles.php?ok=1');
            exit;
        } catch (PDOException $e) {
            $err = '保存失败，请检查 slug 是否重复或联系管理员';
        }
    }
    if ($err) {
        $article = array_merge($article ?? [], compact('title', 'slug', 'category_id', 'summary', 'content', 'is_published'));
        $article['category_id'] = $categoryId;
        $article['is_published'] = $isPublished;
    }
}

if (!$article) {
    $article = ['id' => 0, 'title' => '', 'slug' => '', 'category_id' => 0, 'summary' => '', 'content' => '', 'cover_image' => null, 'is_published' => 1];
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article['id'] ? '编辑' : '新增' ?>文章 - 机器人之家</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&family=Noto+Sans+SC:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/style.css')) ?>">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/admin.css')) ?>">
</head>
<body class="admin-body">
    <?php require __DIR__ . '/includes/nav.php'; ?>
    <div class="admin-main">
        <h1 class="admin-page-title"><?= $article['id'] ? '编辑文章' : '新增文章' ?></h1>
        <?php if ($err): ?><p class="admin-error"><?= e($err) ?></p><?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="admin-form">
            <div class="form-row">
                <label>栏目</label>
                <select name="category_id" required>
                    <?php foreach ($categories as $c): if ($c['slug'] === 'home') continue; ?>
                    <option value="<?= (int)$c['id'] ?>" <?= (int)($article['category_id'] ?? 0) === (int)$c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-row">
                <label>标题</label>
                <input type="text" name="title" value="<?= e($article['title'] ?? '') ?>" required>
            </div>
            <div class="form-row">
                <label>URL 别名 (slug)</label>
                <input type="text" name="slug" value="<?= e($article['slug'] ?? '') ?>" placeholder="留空则根据标题自动生成">
            </div>
            <div class="form-row">
                <label>摘要</label>
                <textarea name="summary" rows="2"><?= e($article['summary'] ?? '') ?></textarea>
            </div>
            <div class="form-row">
                <label>封面图</label>
                <input type="file" name="cover_image" accept="image/jpeg,image/png,image/gif,image/webp">
                <?php if (!empty($article['cover_image'])): ?>
                <p class="form-hint">当前：<img src="<?= e(uploadsUrl($article['cover_image'])) ?>" alt="" style="max-width:120px;height:auto;"> 上传新图将替换</p>
                <?php endif; ?>
            </div>
            <div class="form-row">
                <label>正文 (支持 HTML)</label>
                <textarea name="content" rows="12"><?= e($article['content'] ?? '') ?></textarea>
            </div>
            <div class="form-row">
                <label><input type="checkbox" name="is_published" value="1" <?= !empty($article['is_published']) ? 'checked' : '' ?>> 发布</label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">保存</button>
                <a href="articles.php" class="btn">取消</a>
            </div>
        </form>
    </div>
</body>
</html>
