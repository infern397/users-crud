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

    protected function json($data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}