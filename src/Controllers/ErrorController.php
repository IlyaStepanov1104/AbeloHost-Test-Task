<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    public function index(int $code = 404): void
    {
        $messages = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ];

        http_response_code($code);

        $this->view->assign('code', $code);
        $this->view->assign('message', $messages[$code] ?? 'Unknown Error');
        $this->view->render('pages/error');
    }
}
