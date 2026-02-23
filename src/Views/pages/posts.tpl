{extends file="layouts/default.tpl"}

{block name="content"}
    <section class="blog-section">
        <div class="container">
            <div class="blog-section__grid">
                {foreach $posts as $post}
                    {include file="components/post-card.tpl" post=$post showTags=true}
                {/foreach}
            </div>
        </div>
    </section>
{/block}