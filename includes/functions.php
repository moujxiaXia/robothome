<?php
/**
 * 公共函数 - 机器人之家
 */

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function getCategories(PDO $pdo): array {
    $stmt = $pdo->query('SELECT id, slug, name FROM categories ORDER BY sort_order, id');
    return $stmt->fetchAll();
}

function getCategoryBySlug(PDO $pdo, string $slug): ?array {
    $stmt = $pdo->prepare('SELECT id, slug, name, description FROM categories WHERE slug = ?');
    $stmt->execute([$slug]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getArticles(PDO $pdo, ?int $categoryId = null, int $limit = 50, int $offset = 0): array {
    $sel = 'a.*, c.slug AS category_slug, c.name AS category_name';
    if ($categoryId !== null) {
        $stmt = $pdo->prepare("SELECT $sel FROM articles a JOIN categories c ON a.category_id = c.id WHERE a.category_id = ? AND a.is_published = 1 ORDER BY a.created_at DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $pdo->query("SELECT $sel FROM articles a JOIN categories c ON a.category_id = c.id WHERE a.is_published = 1 ORDER BY a.created_at DESC LIMIT $limit OFFSET $offset");
    }
    return $stmt->fetchAll();
}

function getArticleById(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare('SELECT a.*, c.slug AS category_slug, c.name AS category_name FROM articles a JOIN categories c ON a.category_id = c.id WHERE a.id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getArticleBySlug(PDO $pdo, string $categorySlug, string $articleSlug): ?array {
    $stmt = $pdo->prepare('SELECT a.*, c.slug AS category_slug, c.name AS category_name FROM articles a JOIN categories c ON a.category_id = c.id WHERE c.slug = ? AND a.slug = ? AND a.is_published = 1');
    $stmt->execute([$categorySlug, $articleSlug]);
    return $stmt->fetch() ?: null;
}

function incrementViewCount(PDO $pdo, int $articleId): void {
    $pdo->prepare('UPDATE articles SET view_count = view_count + 1 WHERE id = ?')->execute([$articleId]);
}

function siteName(): string {
    return '机器人之家';
}

function baseUrl(): string {
    $base = defined('BASE_PATH') && BASE_PATH !== '' ? rtrim(BASE_PATH, '/') : '';
    if ($base === '' && isset($_SERVER['SCRIPT_NAME'])) {
        $dir = dirname($_SERVER['SCRIPT_NAME']);
        $dir = str_replace('\\', '/', $dir);
        $base = ($dir === '.' || $dir === '/' || $dir === '') ? '' : rtrim($dir, '/');
    }
    return $base;
}

function assetUrl(string $path): string {
    $root = baseUrl();
    $path = ltrim($path, '/');
    return $root . '/assets/' . $path;
}

function uploadsUrl(string $path): string {
    $root = baseUrl();
    $path = ltrim($path, '/');
    return $root . '/uploads/' . $path;
}

function currentPage(): string {
    return $_GET['page'] ?? 'home';
}

function isActiveNav(string $slug): string {
    return (currentPage() === $slug) ? ' active' : '';
}

/** 可选主题列表（id => 显示名称） */
function getThemesList(): array {
    return [
        'default'   => '默认（深色科技风）',
        'light'     => '浅色简洁',
        'bootstrap' => 'Bootstrap 风格',
    ];
}

/** 当前主题 id */
function getCurrentTheme(): string {
    $file = dirname(__DIR__) . '/config/theme.php';
    if (is_file($file)) {
        $v = include $file;
        if (is_string($v) && $v !== '') {
            $allowed = array_keys(getThemesList());
            if (in_array($v, $allowed, true)) {
                return $v;
            }
        }
    }
    return 'default';
}
