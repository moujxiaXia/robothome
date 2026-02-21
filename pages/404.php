<?php
// $pageTitle already set in router
http_response_code(404);
?>
<section class="section">
    <div class="container" style="text-align: center; padding: 4rem 1rem;">
        <div style="font-size: 6rem; margin-bottom: 1rem;">🤖</div>
        <h1 style="font-size: 2rem; margin-bottom: 1rem; color: var(--text);">404 - 页面未找到</h1>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">抱歉，您访问的页面不存在或已被移除。</p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="/" class="btn btn-primary">返回首页</a>
            <a href="/?page=news" class="btn">浏览新闻</a>
        </div>
    </div>
</section>
