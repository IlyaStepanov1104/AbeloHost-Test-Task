<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CategoryModel;
use App\Models\PostModel;

class GenerateController extends Controller
{
    private const TITLES = [
        'kak-nachat-programmirovat-s-nulya' => 'Как начать программировать с нуля',
        'top-10-oshibok-nachinayushchego-razrabotchika' => 'Топ-10 ошибок начинающего разработчика',
        'pochemu-chisty-kod-vazhnee-bystrogo-koda' => 'Почему чистый код важнее быстрого кода',
        'rest-api-osnovy-kotorye-dolzhen-znat-kazhdyj' => 'REST API: основы, которые должен знать каждый',
        'git-dlya-novichkov-vetki-kommity-i-sliyaniya' => 'Git для новичков: ветки, коммиты и слияния',
        'zachem-nuzhny-patterny-proektirovaniya' => 'Зачем нужны паттерны проектирования',
        'vvedenie-v-docker-dlya-veb-razrabotchikov' => 'Введение в Docker для веб-разработчиков',
        'sql-protiv-nosql-chto-vybrat' => 'SQL против NoSQL: что выбрать',
        'kak-pisat-yunit-testy-i-zachem-eto-delat' => 'Как писать юнит-тесты и зачем это делать',
        'principy-solid-prostymi-slovami' => 'Принципы SOLID простыми словами',
        'mvc-arhitektura-teoriya-i-praktika' => 'MVC-архитектура: теория и практика',
        'chto-takoe-ci-cd-i-kak-eto-rabotaet' => 'Что такое CI/CD и как это работает',
        'bezopasnost-veb-prilozhenij-bazovye-pravila' => 'Безопасность веб-приложений: базовые правила',
        'kak-pravilno-delat-code-review' => 'Как правильно делать code review',
        'refaktoring-kogda-i-kak' => 'Рефакторинг: когда и как',
        'asinhronnoe-programmirovanie-ot-kolbekov-k-async-await' => 'Асинхронное программирование: от колбэков к async/await',
        'kak-stat-senior-razrabotchikom-bystree' => 'Как стать senior-разработчиком быстрее',
        'mikroservisy-vs-monolit-plyusy-i-minusy' => 'Микросервисы vs монолит: плюсы и минусы',
        'osnovy-algoritmov-i-struktur-dannyh' => 'Основы алгоритмов и структур данных',
        'kak-gramotno-dokumentirovat-kod' => 'Как грамотно документировать код',
    ];

    private const IMAGES = [
        'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800',
        'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800',
        'https://images.unsplash.com/photo-1484417894907-623942c8ee29?w=800',
        'https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=800',
        'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800',
        'https://images.unsplash.com/photo-1516116216624-53e697fedbea?w=800',
        'https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=800',
        'https://images.unsplash.com/photo-1537432376769-00f5c2f4c8d2?w=800',
        'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800',
        'https://images.unsplash.com/photo-1508830524289-0adcbe822b40?w=800',
    ];

    private const DESCRIPTIONS = [
        'Разбираем тему от основ до практики — с примерами и пояснениями для начинающих.',
        'Подробный разбор с реальными кейсами из повседневной разработки.',
        'Всё, что нужно знать разработчику, чтобы не наступать на одни и те же грабли.',
        'Практическое руководство с пошаговыми примерами и рекомендациями.',
        'Разбираем концепцию простым языком без лишней теории.',
        'Отвечаем на вопросы, которые чаще всего возникают у новичков.',
        'Обзор подходов и лучших практик, которые применяются в современных проектах.',
        'Сравниваем варианты и разбираем, когда что лучше применять.',
        'Как это работает под капотом и почему это важно знать каждому разработчику.',
        'Теория и практика: от «что это такое» до «как использовать в продакшне».',
    ];

    private const TEXTS = [
        <<<'MD'
## Введение

Программирование — это навык, который можно освоить в любом возрасте. Главное — правильный подход.

## С чего начать

Выберите один язык и изучайте его последовательно. Не пытайтесь охватить всё сразу.

```php
echo "Hello, World!";
```

## Практика

Пишите код каждый день, даже если по 30 минут. Решайте задачи на таких платформах, как LeetCode или HackerRank.

## Итог

Терпение и ежедневная практика — ключ к успеху. Не сравнивайте свой прогресс с чужим.
MD,
        <<<'MD'
## Зачем это нужно

Понимание базовых принципов помогает писать поддерживаемый и читаемый код.

## Основные концепции

- **Разделение ответственности** — каждый модуль делает одно дело.
- **Не повторяй себя (DRY)** — избегайте дублирования кода.
- **KISS** — делайте всё как можно проще.

## Пример

```php
// Плохо
function doEverything() { ... }

// Хорошо
function fetchUser(int $id): array { ... }
function renderUser(array $user): string { ... }
```

## Вывод

Чистый код — это уважение к коллегам и к своему будущему «я».
MD,
        <<<'MD'
## Что такое REST

REST (Representational State Transfer) — архитектурный стиль взаимодействия компонентов.

## Основные принципы

1. Клиент-серверная модель
2. Stateless — сервер не хранит состояние клиента
3. Единый интерфейс — HTTP-методы: GET, POST, PUT, DELETE

## Пример запроса

```http
GET /api/posts HTTP/1.1
Host: example.com
Accept: application/json
```

## Коды ответов

| Код | Значение         |
|-----|-----------------|
| 200 | OK              |
| 201 | Created         |
| 404 | Not Found       |
| 500 | Server Error    |

## Вывод

REST — стандарт де-факто для современных API. Понимание его основ обязательно для каждого бэкенд-разработчика.
MD,
        <<<'MD'
## Введение в Git

Git — система контроля версий, без которой немыслима современная разработка.

## Основные команды

```bash
git init          # инициализировать репозиторий
git add .         # добавить изменения
git commit -m ""  # зафиксировать изменения
git push          # отправить на сервер
```

## Ветки

```bash
git branch feature/auth    # создать ветку
git checkout feature/auth  # переключиться
git merge feature/auth     # влить в основную
```

## Советы

- Делайте атомарные коммиты — один коммит = одно логическое изменение.
- Пишите осмысленные сообщения к коммитам.
- Не коммитьте в `main` напрямую.

## Итог

Git — фундаментальный инструмент. Чем раньше вы его освоите, тем лучше.
MD,
        <<<'MD'
## Что такое тестирование

Тестирование — это проверка того, что код работает так, как ожидается.

## Виды тестов

- **Юнит-тесты** — тестируют отдельные функции/методы.
- **Интеграционные тесты** — тестируют взаимодействие компонентов.
- **E2E-тесты** — тестируют весь пользовательский сценарий.

## Пример юнит-теста на PHP

```php
public function testSlugGeneration(): void
{
    $slug = generateSlug('Hello World');
    $this->assertEquals('hello-world', $slug);
}
```

## Почему это важно

Тесты позволяют рефакторить код без страха что-то сломать. Это сокращает время на ручное тестирование.

## Итог

Начните с юнит-тестов для критически важной логики и постепенно расширяйте покрытие.
MD,
    ];

    public function generate(array $params = []): void
    {
        $count = max(1, min(10, (int) ($_GET['count'] ?? 3)));

        $postModel = new PostModel();
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAll();

        $created = [];

        for ($i = 0; $i < $count; $i++) {
            $baseSlug = array_rand(self::TITLES);
            $slug = $this->makeUniqueSlug($baseSlug);
            $title = self::TITLES[$baseSlug];

            $postId = $postModel->create([
                'title' => $title,
                'slug' => $slug,
                'image' => self::IMAGES[array_rand(self::IMAGES)],
                'description' => self::DESCRIPTIONS[array_rand(self::DESCRIPTIONS)],
                'text' => self::TEXTS[array_rand(self::TEXTS)],
            ]);

            if (!empty($categories)) {
                $shuffled = $categories;
                shuffle($shuffled);
                $pick = array_slice($shuffled, 0, rand(1, min(3, count($shuffled))));
                foreach ($pick as $cat) {
                    $postModel->attachCategory($postId, $cat['id']);
                }
            }

            $created[] = $title;
        }

        $this->view->assign('count', $count);
        $this->view->assign('posts', $created);
        $this->view->render('pages/generate');
    }

    private function makeUniqueSlug(string $base): string
    {
        $slug = $base;

        if ($this->slugExists($slug)) {
            $slug = uniqid($base, true);
        }

        return $slug;
    }

    private function slugExists(string $slug): bool
    {
        $postModel = new PostModel();
        return $postModel->getBySlug($slug) !== null;
    }
}
