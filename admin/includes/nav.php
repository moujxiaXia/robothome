<nav class="admin-nav">
    <a href="index.php" class="admin-nav-brand">◇ 机器人之家</a>
    <a href="index.php">仪表盘</a>
    <a href="articles.php">文章管理</a>
    <a href="theme.php">模板选择</a>
    <a href="../" target="_blank">访问网站</a>
    <span class="admin-nav-user"><?= e($_SESSION['admin_username'] ?? '') ?></span>
    <a href="logout.php">退出</a>
</nav>
