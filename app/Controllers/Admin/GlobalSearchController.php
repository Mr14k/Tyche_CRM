<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Services\SearchService;

class GlobalSearchController extends Controller
{
    public function search(Request $request): void
    {
        $query = $request->get('q', '');
        $service = new SearchService();
        $results = $service->search($query);

        $this->json([
            'query' => $query,
            'results' => $results
        ]);
    }
}
