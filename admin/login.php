<?php
session_start();
require_once __DIR__ . '/../includes/init.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    if ($user !== '' && $pass !== '') {
        $pdo = getDb();
        $stmt = $pdo->prepare('SELECT id, password_hash FROM admins WHERE username = ?');
        $stmt->execute([$user]);
        $admin = $stmt->fetch();
        if ($admin && password_verify($pass, $admin['password_hash'])) {
            $_SESSION['admin_id'] = (int)$admin['id'];
            $_SESSION['admin_username'] = $user;
            header('Location: index.php');
            exit;
        }
    }
    $error = '用户名或密码错误';
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员登录 - 机器人之家</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&family=Noto+Sans+SC:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(assetUrl('/css/style.css')) ?>">
    <style>
        .admin-login { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0d1117 0%, #161b22 50%, #0d1117 100%); }
        .login-box { width: 100%; max-width: 360px; padding: 2rem; background: rgba(22,27,34,0.9); border: 1px solid #30363d; border-radius: 12px; }
        .login-box h1 { font-family: Orbitron, sans-serif; color: #58a6ff; margin-bottom: 1.5rem; font-size: 1.25rem; }
        .login-box label { display: block; color: #8b949e; font-size: 0.875rem; margin-bottom: 0.25rem; }
        .login-box input { width: 100%; padding: 0.75rem; margin-bottom: 1rem; background: #0d1117; border: 1px solid #30363d; border-radius: 6px; color: #c9d1d9; }
        .login-box button { width: 100%; padding: 0.75rem; background: #238636; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; }
        .login-box button:hover { background: #2ea043; }
        .login-error { color: #f85149; font-size: 0.875rem; margin-bottom: 1rem; }
    </style>
</head>
<body class="admin-login">
    <div class="login-box">
        <h1>◇ 管理后台</h1>
        <?php if ($error): ?><p class="login-error"><?= e($error) ?></p><?php endif; ?>
        <form method="post">
            <label>用户名</label>
            <input type="text" name="username" required autofocus>
            <label>密码</label>
            <input type="password" name="password" required>
            <button type="submit">登录</button>
        </form>
    </div>
</body>
</html>
