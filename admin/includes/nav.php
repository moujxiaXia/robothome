<nav class="admin-nav">
    <a href="index.php" class="admin-nav-brand">机器人之家</a>
    <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">📊 仪表盘</a>
    <a href="articles.php" class="<?= basename($_SERVER['PHP_SELF']) === 'articles.php' || basename($_SERVER['PHP_SELF']) === 'article-edit.php' ? 'active' : '' ?>">📝 文章管理</a>
    <a href="theme.php" class="<?= basename($_SERVER['PHP_SELF']) === 'theme.php' ? 'active' : '' ?>">🎨 模板选择</a>
    <a href="../" target="_blank">🌐 访问网站</a>
    <span class="admin-nav-user"><?= e($_SESSION['admin_username'] ?? '') ?></span>
    <a href="logout.php" style="color: var(--admin-danger) !important;">🚪 退出</a>
</nav>
<style>
.admin-nav a.active {
    color: var(--admin-accent) !important;
    background: rgba(56, 189, 248, 0.1);
}
</style>
