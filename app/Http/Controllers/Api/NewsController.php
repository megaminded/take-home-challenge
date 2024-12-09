<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleDateRequest;
use App\Http\Requests\ArticleSearchRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NewsController extends Controller
{
    public function index()
    {
        $articles = ArticleResource::collection(Article::latest()->limit(10)->get());
        return response()->json([
            'success' => true,
            'articles' => $articles
        ]);
    }
    public function search(ArticleSearchRequest $request)
    {
        $search = $request->search;
        $articles = Article::where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->latest()->paginate(20);
        return response()->json([
            'success' => true,
            'articles' => ArticleResource::collection($articles),
            'next_page'
        ]);
    }
    public function category(string $category)
    {
        $articles = Article::where('category', $category)->latest()->get();
        return response()->json([
            'success' => true,
            'articles' => ArticleResource::collection($articles)
        ]);
    }
    public function source(string $source)
    {
        $articles = Article::where('source', $source)->latest()->paginate(20);
        return response()->json([
            'success' => true,
            'articles' => ArticleResource::collection($articles)
        ]);
    }
    public function date(ArticleDateRequest $request)
    {
        try {
            $start = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
            $end   = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();
            $articles = Article::whereDate('publishedAt', '>=', $start)
                ->whereDate('publishedAt', '<=', $start)
                ->paginate(2);
            return response()->json([
                'success' => true,
                'message' => $start,
                'articles' => ArticleResource::collection($articles),
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'error' => $ex->getMessage()
            ]);
        }
    }
}
