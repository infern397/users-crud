<?php

namespace App\Core;

class Controller
{
    protected function render(string $view, array $params = [], string $layout = 'main'): void
    {
        extract($params);

        ob_start();
        require BASE_PATH . "/app/Views/$view.php";
        $content = ob_get_clean();
        require BASE_PATH . "/app/Views/layouts/$layout.php";
    }

    protected function renderPartial(string $view, array $params = []): void
    {
        extract($params);
        require BASE_PATH . "/app/Views/$view.php";
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