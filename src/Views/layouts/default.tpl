<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:"Blogy"}</title>
    <link rel="stylesheet" href="/css/app.css">
    {block name="head"}{/block}
</head>

<body>
    {include file="components/header.tpl"}

    <main class="main">
        {if isset($pageTitle)}
            <div class="container">
                <div class="page-header">
                    {if isset($backUrl)}
                        <a href="{$backUrl}" class="btn">&#8592; Назад</a>
                    {/if}
                    <h1 class="page-header__title">{$pageTitle}</h1>
                </div>
            </div>
        {/if}

        {block name="content"}{/block}
    </main>

    {include file="components/footer.tpl"}
</body>

</html>