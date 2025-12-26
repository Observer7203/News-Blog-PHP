<article class="article-card">
    <a href="/article/{$article.slug}" class="article-card-link">
        <div class="article-card-image">
            {if $article.image}
                <img src="{$article.image}" alt="{$article.title|escape}" loading="lazy">
            {else}
                <div class="article-card-placeholder"></div>
            {/if}
        </div>
        <div class="article-card-content">
            <h3 class="article-card-title">{$article.title|escape}</h3>
            <p class="article-card-description">{$article.description|escape|truncate:120}</p>
            <div class="article-card-meta">
                <span class="article-card-date">{$article.created_at|date_format:"%b %d, %Y"}</span>
                <span class="article-card-views">{$article.views} views</span>
            </div>
        </div>
    </a>
</article>
