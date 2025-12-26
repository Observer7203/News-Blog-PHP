{if $pagination.total > 1}
<nav class="pagination">
    {if $pagination.current > 1}
        <a href="?page={$pagination.current - 1}&sort={$sort}&dir={$dir}" class="pagination-link pagination-prev">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Prev
        </a>
    {/if}

    <div class="pagination-numbers">
        {for $i=1 to $pagination.total}
            {if $i == $pagination.current}
                <span class="pagination-link pagination-current">{$i}</span>
            {elseif $i == 1 || $i == $pagination.total || ($i >= $pagination.current - 2 && $i <= $pagination.current + 2)}
                <a href="?page={$i}&sort={$sort}&dir={$dir}" class="pagination-link">{$i}</a>
            {elseif $i == $pagination.current - 3 || $i == $pagination.current + 3}
                <span class="pagination-dots">...</span>
            {/if}
        {/for}
    </div>

    {if $pagination.current < $pagination.total}
        <a href="?page={$pagination.current + 1}&sort={$sort}&dir={$dir}" class="pagination-link pagination-next">
            Next
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </a>
    {/if}
</nav>
{/if}
