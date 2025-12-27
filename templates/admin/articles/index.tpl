{extends file="admin/layout.tpl"}

{block name="content"}
<div class="admin-toolbar">
    <a href="/admin/articles/create" class="btn btn-primary">+ New Article</a>
</div>

{if $articles|count > 0}
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Views</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {foreach $articles as $article}
        <tr>
            <td>{$article.id}</td>
            <td>{$article.title|escape|truncate:40}</td>
            <td><code>{$article.slug|truncate:20}</code></td>
            <td>{$article.views}</td>
            <td>{$article.created_at|date_format:"%Y-%m-%d"}</td>
            <td class="actions">
                <a href="/article/{$article.slug}" class="btn btn-sm btn-outline" target="_blank">View</a>
                <a href="/admin/articles/edit/{$article.id}" class="btn btn-sm btn-outline">Edit</a>
                <form method="POST" action="/admin/articles/delete/{$article.id}" style="display:inline" onsubmit="return confirm('Delete this article?');">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{else}
<div class="empty-state">
    <p>No articles found.</p>
    <a href="/admin/articles/create" class="btn btn-primary">Create your first article</a>
</div>
{/if}
{/block}
