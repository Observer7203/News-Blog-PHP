{extends file="layouts/main.tpl"}

{block name="content"}
<div class="container">
    <section class="page-header">
        <a href="/" class="back-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Back to Home
        </a>
        <h1 class="page-title">{$category.name|escape}</h1>
        {if $category.description}
            <p class="page-description">{$category.description|escape}</p>
        {/if}
    </section>

    <div class="filter-bar">
        <div class="filter-info">
            <span>{$pagination.total_items} article{if $pagination.total_items != 1}s{/if}</span>
        </div>
        <div class="filter-sort">
            <label for="sort-select">Sort by:</label>
            <select id="sort-select" class="sort-select" onchange="updateSort(this.value)">
                <option value="created_at-DESC" {if $sort == 'created_at' && $dir == 'DESC'}selected{/if}>Newest first</option>
                <option value="created_at-ASC" {if $sort == 'created_at' && $dir == 'ASC'}selected{/if}>Oldest first</option>
                <option value="views-DESC" {if $sort == 'views' && $dir == 'DESC'}selected{/if}>Most viewed</option>
                <option value="views-ASC" {if $sort == 'views' && $dir == 'ASC'}selected{/if}>Least viewed</option>
            </select>
        </div>
    </div>

    <div class="articles-grid">
        {foreach $articles as $article}
            {include file="components/article-card.tpl" article=$article}
        {foreachelse}
            <div class="empty-state">
                <p>No articles in this category</p>
            </div>
        {/foreach}
    </div>

    {include file="components/pagination.tpl"}
</div>

<script>
function updateSort(value) {
    const [sort, dir] = value.split('-');
    const url = new URL(window.location);
    url.searchParams.set('sort', sort);
    url.searchParams.set('dir', dir);
    url.searchParams.set('page', '1');
    window.location = url;
}
</script>
{/block}
