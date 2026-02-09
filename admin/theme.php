<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/includes/auth.php';

$themes = getThemesList();
$current = getCurrentTheme();
$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = trim($_POST['theme'] ?? '');
    if (!isset($themes[$theme])) {
        $err = '请选择有效模板';
    } else {
        $configPath = dirname(__DIR__) . '/config/theme.php';
        $content = "<?php\n/** 当前前台模板（管理后台可修改） */\nreturn " . var_export($theme, true) . ";\n";
        if (file_put_contents($configPath, $content) !== false) {
            $msg = '已切换为「' . $themes[$theme] . '」，请到前台查看效果。';
            $current = $theme;
        } else {
            $err = '保存失败，请检查 config 目录是否可写';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>模板选择 - 机器人之家</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&family=Noto+Sans+SC:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/style.css')) ?>">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/admin.css')) ?>">
</head>
<body class="admin-body">
    <?php require __DIR__ . '/includes/nav.php'; ?>
    <div class="admin-main">
        <h1 class="admin-page-title">模板选择</h1>
        <p class="admin-hint">选择前台网站使用的视觉风格，保存后立即生效。</p>
        <?php if ($msg): ?><p class="admin-msg"><?= e($msg) ?></p><?php endif; ?>
        <?php if ($err): ?><p class="admin-error"><?= e($err) ?></p><?php endif; ?>
        <form method="post" class="admin-form theme-form">
            <div class="theme-options">
                <?php foreach ($themes as $id => $name): ?>
                <label class="theme-option<?= $current === $id ? ' is-current' : '' ?>">
                    <input type="radio" name="theme" value="<?= e($id) ?>" <?= $current === $id ? 'checked' : '' ?>>
                    <span class="theme-name"><?= e($name) ?></span>
                </label>
                <?php endforeach; ?>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">保存</button>
                <a href="../" target="_blank" class="btn">预览前台</a>
            </div>
        </form>
    </div>
</body>
</html>
