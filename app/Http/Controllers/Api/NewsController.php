<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function getAllNews(Request $request)
    {
        $result = $this->newsService->getAllNews();

        return response()->json($result);
    }

    public function insertNews(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $result = $this->newsService->insertNews($data);

        if (!$result['status']) {
            return response()->json($result, 400);
        }

        return response()->json($result, 201);
    }
}
