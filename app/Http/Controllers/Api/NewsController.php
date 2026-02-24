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

    public function getAllNews()
    {
        $result = $this->newsService->getAllNews();

        return response()->json($result);
    }

    // public function insertNews(Request $request)
    // {
    //     $data = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string',
    //         'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);

    //     $result = $this->newsService->insertNews($data);

    //     if (!$result['status']) {
    //         return response()->json($result, 400);
    //     }

    //     return response()->json($result, 201);
    // }

    public function insertNews(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('news', 'public');
        }

        $validated['image'] = $imagePath;

        $result = $this->newsService->insertNews($validated);

        if (!$result['status']) {
            return response()->json($result, 400);
        }

        return response()->json($result, 201);
    }

        // public function updateNews(Request $request)
        // {
        //     $data = $request->validate([
        //         'id'      => 'required|integer',
        //         'title'   => 'required|string|max:255',
        //         'content' => 'required|string',
        //         'image'   => 'nullable|image',
        //     ]);

        //     $id = $data['id'];

        //     $result = $this->newsService->updateNews($id, $data);

        //     if (!$result['status']) {
        //         return response()->json($result, 400);
        //     }

        //     return response()->json($result);
        // }

        public function updateNews(Request $request)
        {
            $data = $request->validate([
                'id'      => 'required|integer',
                'title'   => 'required|string|max:255',
                'content' => 'required|string',
                'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imagePath = null;

            // ✅ Handle file upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')
                    ->store('news', 'public');
                // saves to storage/app/public/news
            }

            $result = $this->newsService->updateNews(
                $data['id'],
                [
                    'title'   => $data['title'],
                    'content' => $data['content'],
                    'image'   => $imagePath
                ]
            );

            if (!$result['status']) {
                return response()->json($result, 400);
            }

            return response()->json($result);
        }
}
