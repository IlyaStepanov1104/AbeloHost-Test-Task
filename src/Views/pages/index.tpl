{extends file="layouts/default.tpl"}

{block name="content"}
    <div class="blog-list">
        {foreach $categories as $category}
            {include file="components/category-section.tpl" category=$category}
        {/foreach}
    </div>
{/block}