{extends file="layouts/default.tpl"}

{block name="content"}
    <section class="blog-section">
        <div class="container">
            <div class="blog-section__grid">
                {foreach $posts as $post}
                    {include file="components/post-card.tpl" post=$post}
                {/foreach}
            </div>
            
            {include file="components/pagination.tpl" baseUrl="/category/{$category.slug}"}
        </div>
    </section>
{/block}