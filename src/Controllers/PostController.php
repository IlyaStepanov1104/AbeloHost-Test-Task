<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\PostModel;
use FastVolt\Helper\Markdown;

class PostController extends Controller
{
    public function index(): void
    {
        $model = new PostModel();
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $total = $model->countAll();
        $perPage = $model->getPerPage();

        $this->view->assign('posts', $model->getAll($page));
        $this->view->assign('totalPages', (int) ceil($total / $perPage));
        $this->view->assign('page', $page);
        $this->view->assign('pageTitle', 'Все статьи');
        $this->view->assign('backUrl', '/');
        $this->view->assign('from', 'posts');
        $this->view->render('pages/posts');
    }

    public function random(): void
    {
        $model = new PostModel();
        $slug = $model->getRandomSlug();

        if ($slug === null) {
            $this->abort(404);
        }

        header('Location: /post/' . $slug);
        exit;
    }

    public function show(array $params): void
    {
        $model = new PostModel();
        $post = $model->getBySlug($params['slug']);

        if ($post === null) {
            $this->abort(404);
        }

        $model->incrementViews($post['id']);

        $post['content'] = Markdown::new()
            ->setContent($post['text'])
            ->toHtml();

        $backUrls = [
            'posts' => '/posts',
            'category' => 'javascript:history.back()',
            'index' => '/',
        ];
        $from = $_GET['from'] ?? 'index';
        $backUrl = $backUrls[$from] ?? '/';

        $this->view->assign('post', $post);
        $this->view->assign('pageTitle', $post['title']);
        $this->view->assign('backUrl', $backUrl);
        $this->view->render('pages/post');
    }
}
