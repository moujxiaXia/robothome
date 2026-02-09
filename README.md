# 机器人之家 (Robot Home)

基于 LAMP（Linux + Apache + MySQL + PHP）的机器人主题内容网站，包含首页、新闻、技术、博客、关于等栏目，支持管理员发布与编辑文章、上传图片。

## 技术栈

- **后端**: PHP 7.4+（推荐 8.x）、PDO + MySQL 5.7+ / MariaDB 10.2+
- **Web 服务器**: Apache（mod_rewrite）
- **前端**: HTML5、CSS3、少量 JavaScript，响应式布局
- **管理**: 会话登录、文章 CRUD、封面图上传

## 功能概览

- **前台**: 首页 / 新闻 / 技术 / 博客 / 关于；文章详情与阅读数
- **后台**: `/admin/` 登录后可管理文章（新增、编辑、删除、发布/草稿）、上传封面图

## 本地运行

### 方式一：仅需 PHP（推荐，无需 MySQL）

**Ubuntu / WSL（本机 Linux）**

在项目根目录执行（若无 PHP 会提示安装 php-cli、php-sqlite3 等）：

```bash
chmod +x run-local.sh
./run-local.sh
```

或手动安装后启动：

```bash
sudo apt update && sudo apt install -y php php-sqlite3 php-mbstring php-xml php-gd
php -S localhost:8080
```

**Windows**

1. 安装 [PHP](https://windows.php.net/download/)（可选用 [XAMPP](https://www.apachefriends.org/) 或 [Laragon](https://laragon.org/)），确保 `php` 已加入系统 PATH。
2. 在项目根目录执行 `php -S localhost:8080`，或双击 **`run-local.bat`**。

**访问**

- 首页: **http://localhost:8080/**
- 后台: **http://localhost:8080/admin/**（账号 **admin** / 密码 **password**）

项目已默认使用 SQLite（`config/database.local.sqlite.php`），首次访问会自动创建 `data/robothome.sqlite` 并初始化表结构，无需安装 MySQL。

### 方式二：使用 MySQL

1. 创建数据库并导入结构：`mysql -u root -p < sql/schema.sql`
2. 复制 `config/database.local.php.example` 为 `config/database.local.php`，填写 `DB_USER`、`DB_PASS` 等（或删除 `config/database.local.sqlite.php` 后使用根目录下的默认 MySQL 配置）。
3. 用 Apache 或 `php -S localhost:8080` 运行，确保 `uploads/` 可写。

## 阿里云 ECS 上基于 LAMP 部署

### 1. 准备 ECS 与 LAMP 环境

- 购买阿里云 ECS（如 CentOS 7/8 或 Ubuntu 20.04）。
- 安装 LAMP（示例 CentOS 7）：

```bash
# 安装 Apache、PHP、MySQL（MariaDB）
sudo yum install -y httpd mariadb-server php php-mysqlnd php-pdo php-mbstring php-xml php-gd

# 启动并设置开机自启
sudo systemctl start httpd mariadb
sudo systemctl enable httpd mariadb

# 安全配置 MySQL（设置 root 密码等）
sudo mysql_secure_installation
```

- 若使用 Ubuntu：

```bash
sudo apt update
sudo apt install -y apache2 php libapache2-mod-php mysql-server php-mysql php-mbstring php-xml php-gd
sudo systemctl start apache2 mysql
sudo systemctl enable apache2 mysql
```

- 确保 Apache 启用 `mod_rewrite`（用于 `.htaccess`）：

```bash
# CentOS/RHEL
sudo sed -i 's/AllowOverride None/AllowOverride All/' /etc/httpd/conf/httpd.conf
# 或针对站点 VirtualHost 的 Directory 设置 AllowOverride All

# Ubuntu
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 2. 创建数据库与用户

```bash
mysql -u root -p
```

```sql
CREATE DATABASE robothome DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'robothome'@'localhost' IDENTIFIED BY '你的强密码';
GRANT ALL PRIVILEGES ON robothome.* TO 'robothome'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

导入表结构：

```bash
mysql -u robothome -p robothome < /path/to/robothome/sql/schema.sql
```

### 3. 上传代码并配置

- 将本项目上传到 ECS（如 `/var/www/robothome` 或 `/var/www/html`）。
- 设置网站根目录为该目录（Apache VirtualHost 中 `DocumentRoot` 指向该路径）。
- 配置数据库：编辑 `config/database.php`，填写 `DB_HOST`（一般为 `localhost`）、`DB_NAME`、`DB_USER`、`DB_PASS`。
- 目录权限：

```bash
sudo chown -R apache:apache /var/www/robothome   # CentOS 常见为 apache
# 或
sudo chown -R www-data:www-data /var/www/robothome  # Ubuntu
sudo chmod -R 755 /var/www/robothome
sudo chmod -R 775 /var/www/robothome/uploads
```

### 4. 安全建议

- 首次登录后台后，修改默认管理员密码（可在 MySQL 中更新 `admins.password_hash`，或后续自行加“修改密码”功能）。
- 生产环境建议为后台使用 HTTPS、限制 `admin` 目录访问 IP（或配合阿里云 WAF/安全组）。
- 不要将 `config/database.php` 中的密码提交到公开仓库；可用环境变量或服务器本地配置覆盖。

### 5. 子目录部署

若网站不在根路径而在子目录（如 `https://你的域名/robothome/`）：

- 在 `config/database.php` 中设置：`define('BASE_PATH', '/robothome');`
- Apache 中对应站点或别名指向该子目录，并保证 `AllowOverride All` 生效。

## 目录结构

```
robothome/
├── index.php           # 前台入口
├── config/
│   └── database.php    # 数据库配置
├── includes/
│   ├── init.php
│   ├── functions.php
│   ├── header.php
│   └── footer.php
├── pages/              # 前台页面模板
├── admin/              # 后台（登录、文章管理）
├── assets/
│   ├── css/
│   └── js/
├── uploads/            # 上传图片目录
├── sql/
│   └── schema.sql
├── .htaccess
└── README.md
```

## 许可证

MIT
