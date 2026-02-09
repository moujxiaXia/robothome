@echo off
cd /d "%~dp0"
echo Starting PHP server at http://localhost:8080
echo Open in browser: http://localhost:8080
echo Admin: http://localhost:8080/admin/  (admin / password)
echo.
php -S localhost:8080 -t "%~dp0" router.php
pause
