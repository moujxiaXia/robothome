@echo off
chcp 65001 >nul
cd /d "%~dp0"
echo.
if "%~1"=="" (
    echo 用法: 先到 https://github.com/new 新建空仓库，然后执行：
    echo   push-to-github.bat https://github.com/你的用户名/robothome.git
    echo.
    set /p REPO="或在此粘贴仓库地址后回车: "
) else (
    set "REPO=%~1"
)
if "%REPO%"=="" (
    echo 未输入仓库地址，退出。
    pause
    exit /b 1
)
echo.
echo 添加远程 origin: %REPO%
git remote remove origin 2>nul
git remote add origin "%REPO%"
git branch -M main
echo 推送到 GitHub...
git push -u origin main
echo.
pause
