<?php
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
            <h1>Users CRUD</h1>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-outline-primary me-2">Login</button>
            <button type="button" class="btn btn-primary">Sign-up</button>
        </div>
    </header>

    <?= $content ?>
</div>

<script src="/assets/bootstrap/bootstrap.min.js"></script>
</body>
</html>