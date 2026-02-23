{extends file="layouts/default.tpl"}

{block name="head"}
    <meta http-equiv="refresh" content="5;url=/posts">
{/block}

{block name="content"}
    <section class="generate-result">
        <div class="container">
            <div class="generate-result__card">
                <div class="generate-result__icon">&#10003;</div>
                <h2 class="generate-result__title">
                    {if $count === 1}
                        Создана 1 статья
                    {elseif $count >= 2 && $count <= 4}
                        Создано {$count} статьи
                    {else}
                        Создано {$count} статей
                    {/if}
                </h2>
                <ul class="generate-result__list">
                    {foreach $posts as $postTitle}
                        <li class="generate-result__item">{$postTitle}</li>
                    {/foreach}
                </ul>
                <p class="generate-result__redirect">
                    Переход на страницу всех статей через <span id="js-countdown">5</span> сек...
                </p>
                <a href="/posts" class="btn">Перейти сейчас</a>
            </div>
        </div>
    </section>

    <script>
        const el = document.getElementById('js-countdown');

        let s = 5;
        let id = setInterval(() => {
            s--;

            if (el) el.textContent = s;

            if (s <= 0) {
                clearInterval(id);
                window.location.href = '/posts';
            }
        }, 1000);
    </script>
{/block}