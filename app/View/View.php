<?php

declare(strict_types=1);

namespace App\View;

use RuntimeException;
use Throwable;

final class View
{
    public function __construct(
        private readonly string $viewsPath
    ) {
        if (!is_dir($this->viewsPath)) {
            throw new RuntimeException(
                sprintf(
                    'O diretório de views "%s" não existe.',
                    $this->viewsPath
                )
            );
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    public function render(
        string $view,
        array $data = [],
        ?string $layout = null
    ): string {
        $content = $this->evaluate(
            $this->resolve($view),
            $data
        );

        if ($layout === null) {
            return $content;
        }

        return $this->evaluate(
            $this->resolve($layout),
            array_merge(
                $data,
                ['content' => $content]
            )
        );
    }

    private function resolve(string $view): string
    {
        $relativePath = str_replace(
            ['.', '\\'],
            '/',
            trim($view)
        );

        $relativePath = trim($relativePath, '/');

        if ($relativePath === '') {
            throw new RuntimeException(
                'O nome da view não pode ser vazio.'
            );
        }

        $filePath = $this->viewsPath
            . DIRECTORY_SEPARATOR
            . $relativePath
            . '.php';

        if (!is_file($filePath) || !is_readable($filePath)) {
            throw new RuntimeException(
                sprintf(
                    'A view "%s" não foi encontrada.',
                    $view
                )
            );
        }

        return $filePath;
    }

    /**
     * @param array<string, mixed> $data
     */
    private function evaluate(
        string $filePath,
        array $data
    ): string {
        $e = static fn (mixed $value): string =>
            htmlspecialchars(
                (string) $value,
                ENT_QUOTES | ENT_SUBSTITUTE,
                'UTF-8'
            );

        extract($data, EXTR_SKIP);

        ob_start();

        try {
            require $filePath;

            return (string) ob_get_clean();
        } catch (Throwable $exception) {
            ob_end_clean();

            throw $exception;
        }
    }
}