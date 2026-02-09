#!/bin/bash
# 机器人之家 - Ubuntu/WSL 本地运行
cd "$(dirname "$0")"

if ! command -v php &>/dev/null; then
    echo "未检测到 PHP，正在安装 php-cli 与 php-sqlite3..."
    sudo apt-get update -qq
    sudo apt-get install -y php-cli php-sqlite3 php-mbstring php-xml php-gd 2>/dev/null || sudo apt install -y php php-sqlite3 php-mbstring php-xml php-gd
fi

echo ""
echo "启动 PHP 内置服务器："
echo "  首页: http://localhost:8080/"
echo "  后台: http://localhost:8080/admin/  (admin / password)"
echo ""
php -S localhost:8080 -t "$(pwd)" router.php
