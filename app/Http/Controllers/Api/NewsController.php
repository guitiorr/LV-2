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

    public function deleteNews(Request $request)
    {
        // Validate that 'id' exists in the raw JSON body
        $request->validate([
            'id' => 'required|integer'
        ]);

        $id = $request->input('id');
        $result = $this->newsService->deleteNews($id);

        if (!$result['status']) {
            return response()->json($result, 400);
        }

        return response()->json($result);
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

    public function updateNews(Request $request)
    {
        // Validate both the ID and the fields to be updated
        $data = $request->validate([
            'id'      => 'required|integer',
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Extract the ID and the rest of the data
        $id = $data['id'];

        // Pass the ID and the array containing title/content to the service
        $result = $this->newsService->updateNews($id, $data);

        // If 'status' is false (e.g., ID not found or SQL error), return 400 Bad Request
        if (!$result['status']) {
            return response()->json($result, 400);
        }

        // Return success response (200 OK)
        return response()->json($result);
    }
}
