<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\PostModel;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    public function show(array $params): void
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->getBySlug($params['slug']);

        if ($category === null) {
            $this->abort(404);
        }

        $postModel = new PostModel();
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $total = $postModel->countByCategory($category['id']);
        $perPage = $postModel->getPerPage();
        $posts = $postModel->getByCategory($category['id'], $page);

        $this->view->assign('category', $category);
        $this->view->assign('posts', $posts);
        $this->view->assign('totalPages', (int) ceil($total / $perPage));
        $this->view->assign('page', $page);
        $this->view->assign('pageTitle', $category['name']);
        $this->view->assign('backUrl', '/');
        $this->view->assign('from', 'category');
        $this->view->render('pages/category');
    }
}
