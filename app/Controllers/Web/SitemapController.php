<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Page;
use App\Helpers\Url;

class SitemapController extends Controller
{
    public function xml(Request $request): void
    {
        $pages = (new Page())->findWhere('status', 'published');

        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Homepage
        echo '<url><loc>' . Url::to('/') . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';

        foreach ($pages as $p) {
            echo '<url><loc>' . Url::to('/page/' . $p['slug']) . '</loc><lastmod>' . date('Y-m-d', strtotime($p['updated_at'])) . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
        }

        echo '</urlset>';
        exit;
    }
}
