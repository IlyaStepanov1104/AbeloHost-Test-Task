{extends file="layouts/default.tpl"}

{block name="content"}
    <section class="post-page">
        <div class="container">
            <article class="post">
                {include file="components/tag-list.tpl" tags=$post.categories}

                <div class="post__date">
                    &#128065; {$post.views}&ensp;&#8226;&ensp;{$post.created_at|date_format:"%B %e, %Y"}
                </div>

                <div class="post__image">
                    <img src="{$post.image}" alt="{$post.title}">
                </div>

                {* Парсим на бэкенде перед рендером MD в HTML, поэтому тут в данном случае ок использовать nofilter *}
                {* Прим.: библиотека fastvolt/markdown преобразует HTML теги в текст: <p> --> &lt;p&gt, поэтому инъекции быть не может *}
                <div class="post__content">{$post.content nofilter}</div>
            </article>
        </div>
    </section>
{/block}