<div class="tag-list">
    {foreach $tags as $tag}
        <a href="/category/{$tag.slug}" class="tag-list__item">{$tag.name}</a>
    {/foreach}
</div>