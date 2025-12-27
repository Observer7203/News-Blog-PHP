{extends file="admin/layout.tpl"}

{block name="content"}
<div class="dashboard">
    {if isset($smarty.get.seeded)}
        <div class="alert alert-success">Test data has been seeded successfully!</div>
    {/if}

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{$categories_count}</div>
            <div class="stat-label">Categories</div>
            <a href="/admin/categories" class="stat-link">Manage</a>
        </div>
        <div class="stat-card">
            <div class="stat-number">{$articles_count}</div>
            <div class="stat-label">Articles</div>
            <a href="/admin/articles" class="stat-link">Manage</a>
        </div>
    </div>

    <div class="dashboard-actions">
        <h2>Quick Actions</h2>
        <div class="actions-grid">
            <a href="/admin/categories/create" class="action-card">
                <span class="action-icon">+</span>
                <span class="action-text">New Category</span>
            </a>
            <a href="/admin/articles/create" class="action-card">
                <span class="action-icon">+</span>
                <span class="action-text">New Article</span>
            </a>
        </div>
    </div>

    <div class="dashboard-seeder">
        <h2>Seed Test Data</h2>
        <p>This will delete all existing data and create sample categories and articles.</p>
        <form method="POST" action="/admin/seed" onsubmit="return confirm('This will delete all existing data. Are you sure?');">
            <button type="submit" class="btn btn-danger">Seed Database</button>
        </form>
    </div>
</div>
{/block}
