<?php
$cat = getCategoryBySlug($pdo, 'tech');
$categoryId = $cat ? (int)$cat['id'] : 0;
$articles = $categoryId ? getArticles($pdo, $categoryId, 20) : [];
?>
<section class="section section-list">
    <div class="container">
        <h1 class="section-title">技术</h1>
        <?php if (!empty($cat['description'])): ?><p class="section-desc"><?= e($cat['description']) ?></p><?php endif; ?>
        <div class="card-grid">
            <?php foreach ($articles as $a): ?>
            <a href="<?= e(baseUrl()) ?>/?page=article&cat=tech&slug=<?= e($a['slug']) ?>" class="card card-link">
                <div class="card-image">
                    <img src="<?= !empty($a['cover_image']) ? e(uploadsUrl($a['cover_image'])) : e(assetUrl('/images/card-placeholder.svg')) ?>" alt="<?= e($a['title']) ?>">
                </div>
                <div class="card-body">
                    <h3 class="card-title"><?= e($a['title']) ?></h3>
                    <?php if (!empty($a['summary'])): ?><p class="card-summary"><?= e($a['summary']) ?></p><?php endif; ?>
                    <time class="card-date"><?= e(date('Y-m-d', strtotime($a['created_at']))) ?></time>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php if (empty($articles)): ?>
        <p class="empty-state">暂无技术文章。</p>
        <?php endif; ?>
    </div>
</section>
