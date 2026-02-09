<?php
/**
 * PHP 内置服务器路由：仅对首页走 index.php，其余由服务器按文件处理
 * 用法: php -S localhost:8080 -t "项目根目录" router.php
 */
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = $uri === '' ? '/' : $uri;

// 仅首页走 index.php（带查询参数如 ?page=article 的请求也是 GET /）
if ($uri === '/' || $uri === '/index.php') {
    require __DIR__ . '/index.php';
    return;
}

// 静态资源或其它 PHP（如 /admin/theme.php）：交给服务器（return false）
$path = __DIR__ . $uri;
if (strpos($uri, '/assets/') === 0 || strpos($uri, '/uploads/') === 0) {
    if (is_file($path)) {
        return false;
    }
}
return false;
