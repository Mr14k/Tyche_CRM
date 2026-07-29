<?php

declare(strict_types=1);

namespace App\Core;

use App\Helpers\Security;

class View
{
    public static function render(string $viewPath, array $data = [], string $layout = 'web'): void
    {
        $baseViewsDir = dirname(__DIR__, 2) . '/views/';
        $file = $baseViewsDir . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($file)) {
            throw new \Exception("View file not found: {$file}");
        }

        // Helper functions & class aliases for views
        $e = function($val) {
            return \App\Helpers\Security::e($val);
        };

        $url = function(string $path = '') {
            return \App\Helpers\Url::to($path);
        };

        // Create class aliases for helper calls in template views
        class_alias(\App\Helpers\Url::class, 'Url');
        class_alias(\App\Helpers\Security::class, 'Security');
        class_alias(\App\Helpers\Format::class, 'Format');
        class_alias(\App\Helpers\Flash::class, 'Flash');

        // Extract view data safely into local variable scope
        extract($data, EXTR_SKIP);

        // Capture child view content
        ob_start();
        require $file;
        $content = ob_get_clean();

        // Render wrapping layout if layout is requested
        if ($layout !== '' && $layout !== 'none') {
            $layoutFile = $baseViewsDir . 'layouts/' . $layout . '.php';
            if (!file_exists($layoutFile)) {
                throw new \Exception("Layout file not found: {$layoutFile}");
            }
            require $layoutFile;
        } else {
            echo $content;
        }
        exit;
    }
}
