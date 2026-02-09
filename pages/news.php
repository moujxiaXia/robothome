<?php
$cat = getCategoryBySlug($pdo, 'news');
$categoryId = $cat ? (int)$cat['id'] : 0;
$articles = $categoryId ? getArticles($pdo, $categoryId, 20) : [];
?>
<section class="section section-list">
    <div class="container">
        <h1 class="section-title">新闻</h1>
        <?php if (!empty($cat['description'])): ?><p class="section-desc"><?= e($cat['description']) ?></p><?php endif; ?>
        <ul class="article-list">
            <?php foreach ($articles as $a): ?>
            <li>
                <a href="<?= e(baseUrl()) ?>/?page=article&cat=news&slug=<?= e($a['slug']) ?>" class="article-list-item">
                    <span class="list-thumb"><img src="<?= !empty($a['cover_image']) ? e(uploadsUrl($a['cover_image'])) : e(assetUrl('/images/card-placeholder.svg')) ?>" alt=""></span>
                    <span class="list-content">
                        <strong><?= e($a['title']) ?></strong>
                        <?php if (!empty($a['summary'])): ?><span class="list-summary"><?= e(mb_substr($a['summary'], 0, 80)) ?>…</span><?php endif; ?>
                        <time><?= e(date('Y-m-d', strtotime($a['created_at']))) ?></time>
                    </span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php if (empty($articles)): ?>
        <p class="empty-state">暂无新闻，敬请期待。</p>
        <?php endif; ?>
    </div>
</section>
