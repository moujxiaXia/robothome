<?php
/**
 * 管理后台认证 - 未登录跳转登录页
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$adminLoggedIn = !empty($_SESSION['admin_id']);
$isLoginPage = (basename($_SERVER['SCRIPT_NAME']) === 'login.php');
if (!$adminLoggedIn && !$isLoginPage) {
    header('Location: login.php');
    exit;
}
