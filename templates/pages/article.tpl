{extends file="layouts/main.tpl"}

{block name="content"}
<article class="article-page">
    <div class="container">
        <header class="article-header">
            <a href="/" class="back-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Back to Home
            </a>

            <div class="article-categories">
                {foreach $categories as $cat}
                    <a href="/category/{$cat.slug}" class="article-category">{$cat.name|escape}</a>
                {/foreach}
            </div>

            <h1 class="article-title">{$article.title|escape}</h1>

            {if $article.description}
                <p class="article-description">{$article.description|escape}</p>
            {/if}

            <div class="article-meta">
                <span class="article-date">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    {$article.created_at|date_format:"%B %d, %Y"}
                </span>
                <span class="article-views">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    {$article.views} views
                </span>
            </div>
        </header>

        {if $article.image}
        <figure class="article-image">
            <img src="{$article.image}" alt="{$article.title|escape}">
        </figure>
        {/if}

        <div class="article-content">
            {$article.content}
        </div>
    </div>
</article>

{if $related_articles|count > 0}
<section class="related-section">
    <div class="container">
        <h2 class="section-title">Related Articles</h2>
        <div class="articles-grid articles-grid-3">
            {foreach $related_articles as $article}
                {include file="components/article-card.tpl" article=$article}
            {/foreach}
        </div>
    </div>
</section>
{/if}
{/block}
