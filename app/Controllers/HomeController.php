<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View\View;

final class HomeController
{
    /**
     * @param array{
     *     name: string,
     *     environment: string,
     *     debug: bool,
     *     base_path: string
     * } $app
     */
    public function __construct(
        private readonly array $app,
        private readonly View $view
    ) {
    }

    public function index(): string
    {
        return $this->view->render(
            view: 'home',
            data: [
                'title' => 'Página inicial',
                'appName' => $this->app['name'],
                'environment' => $this->app['environment'],
            ],
            layout: 'layouts.app'
        );
    }
}