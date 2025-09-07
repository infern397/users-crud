<?php

namespace App\Core;

class Controller
{
    protected function render(string $view, array $params = []): void
    {
        extract($params);
        require __DIR__ . "/../Views/{$view}.php";
    }
}