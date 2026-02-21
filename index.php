<?php
require_once __DIR__ . '/includes/init.php';

$pdo = getDb();
$page = $_GET['page'] ?? 'home';
$allowed = ['home', 'news', 'tech', 'blog', 'about', 'article'];

if (!in_array($page, $allowed, true)) {
    $page = 'home';
}

if ($page === 'article') {
    $catSlug = $_GET['cat'] ?? '';
    $artSlug = $_GET['slug'] ?? '';
    if ($catSlug && $artSlug) {
        $article = getArticleBySlug($pdo, $catSlug, $artSlug);
        if ($article) {
            incrementViewCount($pdo, (int)$article['id']);
            $pageTitle = $article['title'];
            require __DIR__ . '/includes/header.php';
            require __DIR__ . '/pages/article.php';
            require __DIR__ . '/includes/footer.php';
            exit;
        }
    }
    // 文章不存在，显示 404
    http_response_code(404);
    $pageTitle = '页面未找到';
    require __DIR__ . '/includes/header.php';
    require __DIR__ . '/pages/404.php';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = null;
$category = getCategoryBySlug($pdo, $page);
if ($category) {
    $pageTitle = $category['name'];
}

// 检查页面文件是否存在
$pageFile = __DIR__ . '/pages/' . $page . '.php';
if (!file_exists($pageFile)) {
    http_response_code(404);
    $pageTitle = '页面未找到';
    require __DIR__ . '/includes/header.php';
    require __DIR__ . '/pages/404.php';
    require __DIR__ . '/includes/footer.php';
    exit;
}

require __DIR__ . '/includes/header.php';
require $pageFile;
require __DIR__ . '/includes/footer.php';
