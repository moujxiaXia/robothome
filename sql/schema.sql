-- 机器人之家 数据库结构 (MySQL 5.7+ / MariaDB 10.2+)
-- 创建数据库
CREATE DATABASE IF NOT EXISTS robothome DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE robothome;

-- 栏目/分类：home, news, tech, blog, about
CREATE TABLE IF NOT EXISTS categories (
    id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    slug VARCHAR(32) NOT NULL UNIQUE,
    name VARCHAR(64) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    sort_order TINYINT UNSIGNED DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 文章表
CREATE TABLE IF NOT EXISTS articles (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category_id TINYINT UNSIGNED NOT NULL,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    summary VARCHAR(500) DEFAULT NULL,
    content TEXT,
    cover_image VARCHAR(255) DEFAULT NULL,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    view_count INT UNSIGNED DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_category_slug (category_id, slug),
    KEY idx_category_published (category_id, is_published),
    KEY idx_created (created_at),
    CONSTRAINT fk_article_category FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 管理员
CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(64) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 插入默认栏目
INSERT INTO categories (slug, name, description, sort_order) VALUES
('home', '首页', '机器人之家首页', 0),
('news', '新闻', '行业与公司新闻', 1),
('tech', '技术', '技术分享与教程', 2),
('blog', '博客', '随笔与见解', 3),
('about', '关于', '关于我们', 4);

-- 默认管理员：用户名 admin，密码 password（部署后请立即修改）
INSERT INTO admins (username, password_hash) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- 示例首页文章（可选）
INSERT INTO articles (category_id, title, slug, summary, content, is_published) VALUES
(1, '欢迎来到机器人之家', 'welcome', '探索智能与未来的交汇点', '<p>机器人之家致力于分享机器人技术、行业动态与创新应用。在这里，我们连接爱好者、开发者与产业。</p><p>欢迎订阅我们的新闻与技术栏目。</p>', 1);
