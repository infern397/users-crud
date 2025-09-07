<?php

namespace App\Core;

class Controller
{
    protected function render(string $view, array $params = [], string $layout = 'main'): void
    {
        extract($params);

        ob_start();
        require __DIR__ . "/../Views/{$view}.php";
        $content = ob_get_clean();

        require __DIR__ . "/../Views/layouts/$layout.php";
    }
}