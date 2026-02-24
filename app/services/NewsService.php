<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\DB;

class NewsService
{
    /**
     * Get all news with pagination
     */
    public function getAllNews()
    {
        try {
            $newsList = DB::select('EXEC sp_GetAllNews');

            return response()->json([
                'status' => true,
                'message' => 'News retrieved successfully',
                'news_list' => $newsList
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve news',
                'error' => $e->getMessage() // Turn off in production
            ], 500);
        }
    }

    public function deleteNews($id)
    {
        try {
            DB::statement('EXEC sp_DeleteNews @Id = ?', [$id]);

            return [
                'status' => true,
                'message' => 'News deleted successfully'
            ];

        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Failed to delete news',
                'error' => $e->getMessage()
            ];
        }
    }

    public function insertNews(array $data)
    {
        try {
            DB::statement('EXEC sp_InsertNews @Title = ?, @Content = ?, @Image = ?', [
                $data['title'],
                $data['content'],
                $data['image'] ?? null
            ]);

            return [
                'status' => true,
                'message' => 'News created successfully'
            ];

        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Failed to create news',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get news by ID
     */
    public function getNewsById($id)
    {
        return News::findOrFail($id);
    }

    /**
     * Create new news
     */
    public function createNews(array $data)
    {
        return News::create($data);
    }

    /**
     * Update news
     */
    public function updateNews($id, array $data)
    {
        try {
            DB::statement('EXEC sp_UpdateNews @Id = ?, @Title = ?, @Content = ?, @Image = ?', [
                $id,
                $data['title'],
                $data['content'],
                $data['image'] ?? null
            ]);

            return [
                'status' => true,
                'message' => 'News updated successfully'
            ];

        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Failed to update news',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete news
     */
    // public function deleteNews($id)
    // {
    //     return News::destroy($id);
    // }

    /**
     * Search news by title
     */
    public function searchNews($query)
    {
        return News::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->paginate(15);
    }
}
