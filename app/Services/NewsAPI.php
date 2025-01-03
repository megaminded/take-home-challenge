<?php

namespace App\Services;

use App\DataSource;
use App\Interface\IArticleSource;
use App\Models\Article;
use App\Services\NewsService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
 * DataSource: https://newsapi.org/
 */
final class NewsAPI extends NewsService implements IArticleSource
{
    // Data Source
    public const NAME = DataSource::NEWS_API->value;

    // The API key is hardcoded here for simplicity and quick access during development.
    // For production or sensitive applications, I avoid hardcoding API keys or secrets directly in the codebase.
    const URL = "https://newsapi.org/v2/top-headlines?country=us&apiKey=5a0e6751dd81435eb46659a9a977a932";

    /**
     * Parse articles received from News API endpoint
     *
     * @return void
     * @throws \Exception
     **/

    public function fetch(): void
    {
        try {
            $request = Http::get(self::URL);
            $response = $this->process($request);
            $result = $response['articles'] ?? throw new \Exception("There was an error processing article request. Article not found");
            $data = array();
            foreach ($result as $article) {
                array_push($data, $this->parse($article));
            }
            $this->save(collect($data));
            Log::info(self::NAME . ' article fetched successfully');
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
        }
    }

    public function parse(array $article): Article
    {
        return new Article([
            'source' => $article['source']['name'],
            'author' => $article['author'],
            'title' => $article['title'],
            'description' => $article['description'],
            'source_url' => $article['url'],
            'image_url' => $article['urlToImage'],
            'category' => isset($article['category']) ? strtolower($article['category']) : null,
            'publishedAt' => Carbon::parse($article['publishedAt'])->toDateTimeString(),
            'content' => $article['content'],
        ]);
    }
}
