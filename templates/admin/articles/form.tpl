{extends file="admin/layout.tpl"}

{block name="content"}
<div class="form-container">
    <form method="POST" class="admin-form">
        <div class="form-group">
            <label for="title">Title *</label>
            <input type="text" id="title" name="title" value="{if $article}{$article.title|escape}{/if}" required>
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" value="{if $article}{$article.slug|escape}{/if}" placeholder="auto-generated if empty">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="2">{if $article}{$article.description|escape}{/if}</textarea>
        </div>

        <div class="form-group">
            <label for="content">Content (HTML)</label>
            <textarea id="content" name="content" rows="12">{if $article}{$article.content|escape}{/if}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="url" id="image" name="image" value="{if $article}{$article.image|escape}{/if}" placeholder="https://example.com/image.jpg">
        </div>

        <div class="form-group">
            <label>Categories</label>
            <div class="checkbox-group">
                {foreach $categories as $cat}
                <label class="checkbox-label">
                    <input type="checkbox" name="categories[]" value="{$cat.id}" {if in_array($cat.id, $selected_categories)}checked{/if}>
                    {$cat.name|escape}
                </label>
                {foreachelse}
                <p class="text-muted">No categories available. <a href="/admin/categories/create">Create one first.</a></p>
                {/foreach}
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{if $article}Update{else}Create{/if} Article</button>
            <a href="/admin/articles" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
{/block}
