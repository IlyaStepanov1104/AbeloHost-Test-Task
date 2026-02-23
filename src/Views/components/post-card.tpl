<post class="blog-card">
    <a href="/post/{$post.slug}{if isset($from)}?from={$from}{/if}" class="blog-card__overlay"></a>

    <div class="blog-card__image-wrapper">
        <img src="{$post.image}" alt="{$post.title}" class="blog-card__image">
    </div>

    <h3 class="blog-card__title">{$post.title}</h3>

    {if isset($showTags) && $showTags}
        {include file="components/tag-list.tpl" tags=$post.categories}
    {/if}

    <div class="blog-card__date">
        &#128065; {$post.views}&ensp;&#8226;&ensp;{$post.created_at|date_format:"%d %B %Y"}
    </div>
    <div class="blog-card__description">{$post.description}</div>
</post>