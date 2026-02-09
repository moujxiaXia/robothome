<?php
if (!isset($pdo)) $pdo = getDb();
$categories = getCategories($pdo);
$current = currentPage();
$theme = getCurrentTheme();
?>
<!DOCTYPE html>
<html lang="zh-CN" class="theme-<?= e($theme) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' - ' : '' ?><?= e(siteName()) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Noto+Sans+SC:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/style.css')) ?>">
    <?php if ($theme === 'light'): ?>
    <link rel="stylesheet" href="<?= e(assetUrl('/css/themes/light.css')) ?>">
    <?php elseif ($theme === 'bootstrap'): ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/themes/bootstrap.css')) ?>">
    <?php endif; ?>
    <link rel="icon" type="image/svg+xml" href="<?= e(assetUrl('/images/favicon.svg')) ?>">
    <meta name="theme-color" content="<?= $theme === 'light' ? '#f5f5f5' : '#0a0e14' ?>">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="<?= e(baseUrl()) ?>/" class="logo">
                <span class="logo-icon">◇</span>
                <span class="logo-text"><?= e(siteName()) ?></span>
            </a>
            <nav class="nav-main">
                <?php foreach ($categories as $cat): if ($cat['slug'] === 'home') continue; ?>
                <a href="<?= e(baseUrl()) ?>/?page=<?= e($cat['slug']) ?>" class="nav-link<?= $current === $cat['slug'] ? ' active' : '' ?>"><?= e($cat['name']) ?></a>
                <?php endforeach; ?>
            </nav>
            <button class="nav-toggle" aria-label="菜单" type="button"></button>
        </div>
    </header>
    <main class="site-main">
