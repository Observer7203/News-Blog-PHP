{extends file="admin/layout.tpl"}

{block name="content"}
<div class="form-container">
    <form method="POST" class="admin-form">
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" value="{if $category}{$category.name|escape}{/if}" required>
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" value="{if $category}{$category.slug|escape}{/if}" placeholder="auto-generated if empty">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3">{if $category}{$category.description|escape}{/if}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{if $category}Update{else}Create{/if} Category</button>
            <a href="/admin/categories" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
{/block}
