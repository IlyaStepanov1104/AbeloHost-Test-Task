<section class="blog-section">
    <div class="container">
        <div class="blog-section__top">
            <div class="blog-section__title">
                {$category.name}
            </div>

            <a href="/category/{$category.slug}" class="blog-section__view-all">View All</a>
        </div>

        <div class="blog-section__grid">
            {foreach $category.posts as $post}
                {include file="components/post-card.tpl" post=$post}
            {/foreach}
        </div>
    </div>
</section>