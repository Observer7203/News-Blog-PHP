{extends file="admin/layout.tpl"}

{block name="content"}
<div class="admin-toolbar">
    <a href="/admin/categories/create" class="btn btn-primary">+ New Category</a>
</div>

{if $categories|count > 0}
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {foreach $categories as $category}
        <tr>
            <td>{$category.id}</td>
            <td>{$category.name|escape}</td>
            <td><code>{$category.slug}</code></td>
            <td>{$category.description|escape|truncate:50}</td>
            <td class="actions">
                <a href="/admin/categories/edit/{$category.id}" class="btn btn-sm btn-outline">Edit</a>
                <form method="POST" action="/admin/categories/delete/{$category.id}" style="display:inline" onsubmit="return confirm('Delete this category?');">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{else}
<div class="empty-state">
    <p>No categories found.</p>
    <a href="/admin/categories/create" class="btn btn-primary">Create your first category</a>
</div>
{/if}
{/block}
