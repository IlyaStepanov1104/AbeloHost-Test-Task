<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CategoryModel;

class IndexController extends Controller
{
    public function index(array $params = []): void
    {
        $categoryModel = new CategoryModel();

        $this->view->assign('categories', $categoryModel->getAllWithPosts());
        $this->view->assign('from', 'index');
        $this->view->render('pages/index');
    }
}
