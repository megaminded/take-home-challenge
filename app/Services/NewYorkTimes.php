<?php

namespace App\Services;

use App\DataSource;
use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class NewsAPI extends News
{
    public function process(): void
    {
        $url = DataSource::NYK->value + env('NYK_API_KEY');
        try {
            $response = Http::get($url);
            if ($response->successful()) {
                $data = array();
                $articles = $response->json();
                foreach ($articles as $key => $article) {
                    array_push($data, new Article([
                        'source' => $article['source'],
                        'category' => $article['category'],
                        'title' => $article['title'],
                        'description' => $article['description'],
                        'author' => $article['author'],
                        'image_url' => $article['image_url'],
                        'source_url' => $article['source_url'],
                        'publishedAt' => $article['publishedAt'],
                        'content' => $article['content'],
                    ]));
                }
                $this->save($data);
            }
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
        }
    }
}
