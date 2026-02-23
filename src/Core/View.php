<?php

namespace App\Core;

use Smarty\Smarty;

class View
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();

        $root = dirname(__DIR__, 2);

        $this->smarty->setTemplateDir($root . '/src/Views');
        $this->smarty->setCompileDir($root . '/storage/cache/smarty/compiled');
        $this->smarty->setCacheDir($root . '/storage/cache/smarty/cache');
        $this->smarty->setConfigDir($root . '/config');

        $this->smarty->debugging = ($_ENV['APP_DEBUG'] ?? false);
    }

    public function assign(string $key, mixed $value): void
    {
        $this->smarty->assign($key, $value);
    }

    public function render(string $template): void
    {
        $this->smarty->display($template . '.tpl');
    }
}
