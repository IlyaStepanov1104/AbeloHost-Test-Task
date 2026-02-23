{extends file="layouts/default.tpl"}

{block name="content"}

    <section class="error-page">
        <div class="container">
            <div class="error-page__wrapper">

                <div class="error-page__code">
                    {$code}
                </div>

                <h1 class="error-page__title">
                    {$message}
                </h1>

                <div class="error-page__message">
                    Try again later.
                </div>

                <div class="error-page__action">
                    <a href="/" class="btn">
                        Back to Home
                    </a>
                </div>

            </div>
        </div>
    </section>

{/block}