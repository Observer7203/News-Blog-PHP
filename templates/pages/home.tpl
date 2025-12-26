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
    <div class="empty-state">
        <p>No articles found</p>
    </div>
    {/foreach}
</div>
{/block}
