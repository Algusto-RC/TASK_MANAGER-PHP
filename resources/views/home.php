<?php

declare(strict_types=1);
?>
<section class="hero">
    <div class="container hero-content">
        <div class="hero-text">
            <span class="status-badge">
                Aplicação inicializada
            </span>

            <h1>
                Organize suas tarefas com simplicidade.
            </h1>

            <p class="hero-description">
                Cadastre, acompanhe e conclua suas tarefas
                em uma aplicação desenvolvida com PHP,
                MySQL e PDO.
            </p>

            <div class="hero-actions">
                <a class="button button-primary" href="/register">
                    Criar minha conta
                </a>

                <a class="button button-secondary" href="/login">
                    Já tenho uma conta
                </a>
            </div>
        </div>

        <aside class="project-card">
            <h2>Estado da aplicação</h2>

            <dl class="project-information">
                <div>
                    <dt>Aplicação</dt>
                    <dd><?= $e($appName) ?></dd>
                </div>

                <div>
                    <dt>Ambiente</dt>
                    <dd><?= $e($environment) ?></dd>
                </div>

                <div>
                    <dt>Roteamento</dt>
                    <dd>Configurado</dd>
                </div>

                <div>
                    <dt>Views</dt>
                    <dd>Configuradas</dd>
                </div>
            </dl>
        </aside>
    </div>
</section>

<section class="features">
    <div class="container">
        <div class="section-heading">
            <span>Funcionalidades</span>

            <h2>
                Recursos planejados para o sistema
            </h2>
        </div>

        <div class="feature-grid">
            <article class="feature-card">
                <h3>Autenticação</h3>

                <p>
                    Cadastro de usuários, login seguro
                    e encerramento de sessão.
                </p>
            </article>

            <article class="feature-card">
                <h3>Gerenciamento</h3>

                <p>
                    Criação, edição, acompanhamento
                    e exclusão de tarefas.
                </p>
            </article>

            <article class="feature-card">
                <h3>Organização</h3>

                <p>
                    Filtros por status, prioridade
                    e prazo de conclusão.
                </p>
            </article>
        </div>
    </div>
</section>