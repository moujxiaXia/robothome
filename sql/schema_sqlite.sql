-- SQLite 结构（本地无 MySQL 时使用）
CREATE TABLE IF NOT EXISTS categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    slug VARCHAR(32) NOT NULL UNIQUE,
    name VARCHAR(64) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    sort_order INTEGER DEFAULT 0
);

CREATE TABLE IF NOT EXISTS articles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    category_id INTEGER NOT NULL,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    summary VARCHAR(500) DEFAULT NULL,
    content TEXT,
    cover_image VARCHAR(255) DEFAULT NULL,
    is_published INTEGER NOT NULL DEFAULT 1,
    view_count INTEGER DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(category_id, slug),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE IF NOT EXISTS admins (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(64) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT OR IGNORE INTO categories (id, slug, name, description, sort_order) VALUES
(1, 'home', '首页', '机器人之家首页', 0),
(2, 'news', '新闻', '行业与公司新闻', 1),
(3, 'tech', '技术', '技术分享与教程', 2),
(4, 'blog', '博客', '随笔与见解', 3),
(5, 'about', '关于', '关于我们', 4);

INSERT OR IGNORE INTO admins (id, username, password_hash) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT OR IGNORE INTO articles (id, category_id, title, slug, summary, content, is_published) VALUES
(1, 1, '欢迎来到机器人之家', 'welcome', '探索智能与未来的交汇点', '<p>机器人之家致力于分享机器人技术、行业动态与创新应用。在这里，我们连接爱好者、开发者与产业。</p><p>欢迎订阅我们的新闻与技术栏目。</p>', 1);
