{if $totalPages > 1}
    <nav class="pagination">
        {if $page > 1}
            <a href="{$baseUrl}?page={$page - 1}" class="pagination__btn">&#8592;</a>
        {else}
            <span class="pagination__btn pagination__btn--disabled">&#8592;</span>
        {/if}

        {for $p = 1 to $totalPages}
            {if $p == $page}
                <span class="pagination__page pagination__page--active">{$p}</span>
            {elseif $p == 1 || $p == $totalPages || ($p >= $page - 2 && $p <= $page + 2)}
                <a href="{$baseUrl}?page={$p}" class="pagination__page">{$p}</a>
            {elseif $p == $page - 3 || $p == $page + 3}
                <span class="pagination__dots">…</span>
            {/if}
        {/for}

        {if $page < $totalPages}
            <a href="{$baseUrl}?page={$page + 1}" class="pagination__btn">&#8594;</a>
        {else}
            <span class="pagination__btn pagination__btn--disabled">&#8594;</span>
        {/if}
    </nav>
{/if}
