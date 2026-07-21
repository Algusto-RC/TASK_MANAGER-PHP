<?php

declare(strict_types=1);

$pageTitle = isset($title)
    ? $title . ' | ' . $appName
    : $appName;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Sistema web para gerenciamento de tarefas."
    >

    <title><?= $e($pageTitle) ?></title>

    <link
        rel="stylesheet"
        href="/assets/css/app.css"
    >
</head>

<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="brand" href="/">
                <?= $e($appName) ?>
            </a>

            <nav
                class="main-navigation"
                aria-label="Navegação principal"
            >
                <a href="/">Início</a>
                <a href="/login">Entrar</a>
                <a class="button-link" href="/register">
                    Criar conta
                </a>
            </nav>
        </div>
    </header>

    <main class="page-content">
        <?= $content ?>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>
                &copy; <?= date('Y') ?>
                <?= $e($appName) ?>.
            </p>
        </div>
    </footer>
</body>
</html>