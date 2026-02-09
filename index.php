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
    $page = 'home';
}

$pageTitle = null;
$category = getCategoryBySlug($pdo, $page);
if ($category) {
    $pageTitle = $category['name'];
}

require __DIR__ . '/includes/header.php';
require __DIR__ . '/pages/' . $page . '.php';
require __DIR__ . '/includes/footer.php';
