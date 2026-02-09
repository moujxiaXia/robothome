#!/bin/bash
# 在项目根目录执行: ./preview-templates.sh
cd "$(dirname "$0")"

echo ""
echo "========== 模板预览 =========="
echo ""

[ ! -d templates ] && echo "[提示] templates 目录不存在，请先按 TEMPLATES.md 下载模板。" && exit 1

# 用系统默认浏览器打开 HTML（macOS 用 open，Linux 用 xdg-open）
open_file() {
    [ -f "$1" ] && (
        if command -v xdg-open >/dev/null 2>&1; then xdg-open "$1"
        elif command -v open >/dev/null 2>&1; then open "$1"
        else echo "请手动用浏览器打开: $1"
        fi
    )
}

echo "[1] 打开 HTML 模板..."
open_file "templates/startbootstrap-landing/dist/index.html"
open_file "templates/startbootstrap-modern-business/dist/index.html"
open_file "templates/startbootstrap-clean-blog/dist/index.html"

echo ""
echo "[2] PHP 模板 (php-bootstrap-basic)"
if [ -f "templates/php-bootstrap-basic/index.php" ]; then
    echo "    在终端执行: cd templates/php-bootstrap-basic && php -S localhost:8081"
    echo "    然后打开: http://localhost:8081"
    echo ""
    read -p "是否现在启动 PHP 服务? (y/N): " ans
    if [ "$ans" = "y" ] || [ "$ans" = "Y" ]; then
        cd templates/php-bootstrap-basic && php -S localhost:8081
    fi
else
    echo "    未找到 php-bootstrap-basic，请先下载模板。"
fi
