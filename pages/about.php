<?php
$cat = getCategoryBySlug($pdo, 'about');
$categoryId = $cat ? (int)$cat['id'] : 0;
$articles = $categoryId ? getArticles($pdo, $categoryId, 5) : [];
?>
<section class="section section-about">
    <div class="container">
        <h1 class="section-title">关于我们</h1>
        <?php if (!empty($cat['description'])): ?><p class="section-desc"><?= e($cat['description']) ?></p><?php endif; ?>
        <?php if (!empty($articles)): ?>
        <div class="about-content">
            <?php foreach ($articles as $a): ?>
            <article class="about-article">
                <h2><?= e($a['title']) ?></h2>
                <div class="about-body"><?= $a['content'] ?></div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="about-content">
            <article class="about-article">
                <h2>关于机器人之家</h2>
                <div class="about-body">
                    <p>机器人之家是一个专注于机器人技术、行业动态与创新应用的平台。我们致力于连接爱好者、开发者与产业，分享前沿技术与实践心得。</p>
                    <p>欢迎通过新闻、技术、博客等栏目了解我们，也欢迎投稿与交流。</p>
                </div>
            </article>
        </div>
        <?php endif; ?>
    </div>
</section>
