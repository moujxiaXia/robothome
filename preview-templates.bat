@echo off
chcp 65001 >nul
cd /d "%~dp0"
echo.
echo ========== 模板预览 ==========
echo.

if not exist "templates" (
    echo [提示] templates 目录不存在，请先按 TEMPLATES.md 下载模板。
    pause
    exit /b 1
)

echo [1] 用浏览器打开 HTML 模板（无需 PHP）
echo     - 落地页: startbootstrap-landing
echo     - 企业站: startbootstrap-modern-business
echo     - 博客:   startbootstrap-clean-blog
echo.
if exist "templates\startbootstrap-landing\dist\index.html" (
    start "" "templates\startbootstrap-landing\dist\index.html"
    echo     已打开: startbootstrap-landing
)
if exist "templates\startbootstrap-modern-business\dist\index.html" (
    start "" "templates\startbootstrap-modern-business\dist\index.html"
    echo     已打开: startbootstrap-modern-business
)
if exist "templates\startbootstrap-clean-blog\dist\index.html" (
    start "" "templates\startbootstrap-clean-blog\dist\index.html"
    echo     已打开: startbootstrap-clean-blog
)

echo.
echo [2] PHP 模板 (php-bootstrap-basic) 需要 PHP 服务
if exist "templates\php-bootstrap-basic\index.php" (
    echo     在 templates\php-bootstrap-basic 下执行: php -S localhost:8081
    echo     然后在浏览器打开: http://localhost:8081
    echo.
    set /p START_PHP="是否现在启动 PHP 服务并打开浏览器? (y/N): "
    if /i "%START_PHP%"=="y" (
        start "PHP-8081" cmd /k "cd /d templates\php-bootstrap-basic && php -S localhost:8081"
        timeout /t 2 /nobreak >nul
        start "" "http://localhost:8081"
        echo     已启动，浏览器将打开 http://localhost:8081 （关闭弹出的命令行窗口即停止服务）
    )
)

echo.
echo ========== 其他页面 ==========
echo 企业站更多页面在: templates\startbootstrap-modern-business\dist\
echo   about.html, blog-home.html, contact.html, pricing.html 等
echo 博客更多页面在: templates\startbootstrap-clean-blog\dist\
echo   about.html, contact.html, post.html
echo.
pause
