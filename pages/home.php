<?php
$catHome = getCategoryBySlug($pdo, 'home');
$categoryId = $catHome ? (int)$catHome['id'] : 0;
$articles = $categoryId ? getArticles($pdo, $categoryId, 6) : [];
$recent = getArticles($pdo, null, 4);
?>
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <h1 class="hero-title">机器人之家</h1>
        <p class="hero-subtitle">探索智能与未来的交汇点</p>
    </div>
</section>
<section class="section section-home-intro">
    <div class="container">
        <?php if (!empty($articles)): ?>
        <div class="intro-block">
            <?php foreach (array_slice($articles, 0, 1) as $a): ?>
            <article class="intro-article">
                <h2><?= e($a['title']) ?></h2>
                <div class="intro-body"><?= $a['content'] ?></div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="home-cards">
            <?php foreach ($recent as $a): ?>
            <a href="<?= e(baseUrl()) ?>/?page=article&cat=<?= e($a['category_slug'] ?? '') ?>&slug=<?= e($a['slug']) ?>" class="card card-link">
                <div class="card-image">
                    <img src="<?= !empty($a['cover_image']) ? e(uploadsUrl($a['cover_image'])) : e(assetUrl('/images/card-placeholder.svg')) ?>" alt="<?= e($a['title']) ?>">
                </div>
                <div class="card-body">
                    <span class="card-cat"><?= e($a['category_name'] ?? '') ?></span>
                    <h3 class="card-title"><?= e($a['title']) ?></h3>
                    <?php if (!empty($a['summary'])): ?><p class="card-summary"><?= e($a['summary']) ?></p><?php endif; ?>
                    <time class="card-date"><?= e(date('Y-m-d', strtotime($a['created_at']))) ?></time>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
