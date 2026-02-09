<?php
// $article from router
?>
<section class="section section-article">
    <div class="container container-narrow">
        <article class="article-single">
            <header class="article-header">
                <span class="article-cat"><?= e($article['category_name']) ?></span>
                <h1 class="article-title"><?= e($article['title']) ?></h1>
                <div class="article-meta">
                    <time><?= e(date('Y年n月j日', strtotime($article['created_at']))) ?></time>
                    <?php if (!empty($article['view_count'])): ?><span class="views">阅读 <?= (int)$article['view_count'] ?></span><?php endif; ?>
                </div>
            </header>
            <?php if (!empty($article['cover_image'])): ?>
            <div class="article-cover"><img src="<?= e(uploadsUrl($article['cover_image'])) ?>" alt="<?= e($article['title']) ?>"></div>
            <?php endif; ?>
            <div class="article-body"><?= $article['content'] ?></div>
            <footer class="article-footer">
                <a href="<?= e(baseUrl()) ?>/?page=<?= e($article['category_slug']) ?>" class="back-link">← 返回<?= e($article['category_name']) ?></a>
            </footer>
        </article>
    </div>
</section>
