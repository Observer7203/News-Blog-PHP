{extends file="layouts/main.tpl"}

{block name="content"}
<div class="container">
    <section class="hero">
        <h1 class="hero-title">Blog</h1>
        <p class="hero-subtitle">Latest articles and insights</p>
    </section>

    {foreach $categories as $category}
    <section class="category-section">
        <div class="category-header">
            <div class="category-info">
                <h2 class="category-title">{$category.name|escape}</h2>
                {if $category.description}
                    <p class="category-description">{$category.description|escape}</p>
                {/if}
            </div>
            <a href="/category/{$category.slug}" class="btn btn-outline">See all</a>
        </div>

        <div class="articles-grid">
            {foreach $category.articles as $article}
                {include file="components/article-card.tpl" article=$article}
            {/foreach}
        </div>
    </section>
    {foreachelse}
    <div class="empty-state empty-state-large">
        <div class="empty-state-icon">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2z"></path>
            </svg>
        </div>
        <h2 class="empty-state-title">No posts yet</h2>
        <p class="empty-state-text">There are no articles or categories available at the moment.</p>
    </div>
    {/foreach}
</div>
{/block}
