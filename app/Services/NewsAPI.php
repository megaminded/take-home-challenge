<?php

namespace App\Services;

use App\DataSource;
use App\Interface\IArticleSource;
use App\Services\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

final class NewsAPI extends News implements IArticleSource
{
    /**
     * Handle articles received from News API endpoint
     *
     * @return void
     * @throws \Exception
     **/

    public function fetch(): void
    {
        try {
            $url = DataSource::NewsAPI->value . env('NEWS_API_KEY');
            $request = Http::get($url);
            $response = $this->process($request);
            $result = $response['articles'] ?? throw new \Exception("There was an error processing article request. Article not found");
            $data = array();
            foreach ($result as $key => $article) {
                array_push($data, [
                    'source' => $article['source']['name'],
                    'author' => $article['author'],
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'source_url' => $article['url'],
                    'image_url' => $article['urlToImage'],
                    'category' => $article['category'] ?? null,
                    'publishedAt' => $article['publishedAt'],
                    'content' => $article['content'],
                ]);
            }
            $this->save($data);
            echo "Successful";
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
        }
    }
}
