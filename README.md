# SOLUTION

- [Условие задачи](TASK.md)
- [Использование ИИ в проекте](AI_USAGE.md)

## Технологический стек

- **PHP 8.2** — без фреймворков
- **MySQL 8.0** — реляционная база данных
- **Smarty 5** — шаблонизатор
- **Phinx** — миграции и сидинг БД
- **ScssPhp** — компиляция SCSS в CSS
- **FastVolt Markdown** — рендеринг Markdown в HTML
- **Docker** — PHP 8.2 + Apache + MySQL в контейнерах

---

## Архитектура

Проект построен по паттерну **MVC**:

```
/config         — маршруты (routes.php)
/src
  /Core         — Router, Controller, Model, Database, View
  /Controllers  — IndexController, PostController, CategoryController, ErrorController, GenerateController
  /Models       — PostModel, CategoryModel
  /Views        — Smarty-шаблоны (layouts, pages, components)
/db
  /migrations   — Phinx-миграции (таблицы categories, posts, post_category)
  /seeds        — BlogSeeder (5 категорий, 12 статей)
/resources/scss — SCSS-стили, компилируются в public/css/app.css
/docker         — Dockerfile для PHP + Apache
/public         — точка входа (index.php), скомпилированные ассеты
```

### Роутер

Реализован кастомный роутер с поддержкой динамических сегментов (`:slug`).
Запрос поступает в `public/index.php`, маршруты описаны в `config/routes.php`.

| Маршрут | Контроллер | Описание |
|---|---|---|
| `GET /` | IndexController | Главная: категории с 3 последними постами каждая |
| `GET /posts` | PostController | Все статьи с пагинацией |
| `GET /post/:slug` | PostController | Страница статьи |
| `GET /category/:slug` | CategoryController | Страница категории с постами |
| `GET /random` | PostController | Редирект на случайную статью |
| `GET /generate` | GenerateController | Генерация тестовых постов |

---

## Структура базы данных

Три таблицы, схема создаётся через Phinx-миграции:

- **categories** — id, name, slug (unique), description, created_at, updated_at
- **posts** — id, title, slug (unique), image, description, text, views, created_at, updated_at
- **post_category** — составной PK (post_id, category_id), связь many-to-many с CASCADE

---

## Реализованные страницы

### Главная страница (`/`)
- Выводит все категории, в которых есть статьи
- В каждой категории — 3 последних поста по дате публикации
- Кнопка «Все статьи» ведёт на страницу категории

### Страница категории (`/category/:slug`)
- Название и описание категории
- Список статей с пагинацией (10 на страницу)
- Сортировка: по дате публикации и по количеству просмотров

### Страница статьи (`/post/:slug`)
- Полная информация о статье (изображение, заголовок, категории, дата, просмотры)
- Текст статьи хранится в Markdown, рендерится в HTML через FastVolt
- Счётчик просмотров увеличивается при каждом открытии
- Контекстная кнопка «Назад» (возврат на список постов, страницу категории или главную)

---

## Компоненты шаблонов

Шаблоны разделены на переиспользуемые компоненты (`src/Views/components/`):

| Компонент | Описание |
|---|---|
| `header.tpl` | Шапка сайта с навигацией |
| `footer.tpl` | Подвал сайта |
| `post-card.tpl` | Карточка статьи (изображение, заголовок, описание, теги, дата, просмотры) |
| `category-section.tpl` | Блок категории с сеткой карточек (используется на главной) |
| `tag-list.tpl` | Список тегов-категорий со ссылками |
| `pagination.tpl` | Пагинация с кнопками «назад/вперёд» и умным сокращением страниц через `…` |

Страницы (`src/Views/pages/`) наследуют общий макет `layouts/default.tpl` через механизм `{extends}` / `{block}` Smarty и подключают нужные компоненты через `{include}`.

---

## Дополнительный функционал

### Сидинг данных
Команда `composer seed` заполняет БД: 5 категорий и 12 статей на русском языке с реальным Markdown-текстом и изображениями с Unsplash. Связи постов и категорий — many-to-many.

### SCSS
Стили написаны на SCSS с переменными для цветов, отступов и шрифтов. Компиляция запускается командой `composer scss`.

### Docker
Окружение поднимается командой `docker-compose up`:
- PHP 8.2 + Apache (DocumentRoot → `/public`)
- MySQL 8.0

### Генерация тестовых данных
Маршрут `/generate?count=N` создаёт до 10 случайных постов из предустановленного банка заголовков и контента.

---

## Запуск проекта

```bash
# Поднять окружение
docker-compose up -d

# Установить зависимости
composer install

# Запустить миграции
composer migrate

# Заполнить БД тестовыми данными
composer seed

# Скомпилировать SCSS
composer scss
```
