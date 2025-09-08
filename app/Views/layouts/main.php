<?php
use App\Core\UserContext;

/**
 * @var string $content
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'App' ?></title>
    <link href="/assets/bootstrap/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <header class="py-2 d-flex justify-content-between align-items-center">
        <div class="col">
            <a href="/" class="text-decoration-none text-dark">
                <h1>Users CRUD</h1>
            </a>
        </div>
        <div class="col text-end">
            <?php if (UserContext::check()): ?>
                <a href="/logout" class="btn btn-danger">Выйти</a>
            <?php else: ?>
                <a href="/login" class="btn btn-outline-primary me-2">Войти</a>
                <a href="/register" class="btn btn-primary">Зарегистрироваться</a>
            <?php endif; ?>
        </div>
    </header>

    <?= $content ?>
</div>

<script src="/assets/bootstrap/bootstrap.min.js"></script>
</body>
</html>