<?php

namespace App\Services;

use App\DataSource;
use App\Interface\IArticleSource;
use App\Models\Article;
use App\Services\NewsService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
 * Data source: https://api.nytimes.com/
 */
final class NewYorkTimes extends NewsService implements IArticleSource
{
    private const NAME = DataSource::NEW_YORK_TIMES->name;

    // The API key is hardcoded here for simplicity and quick access during development.
    // For production or sensitive applications, I avoid hardcoding API keys or secrets directly in the codebase.
    private const URL = 'https://api.nytimes.com/svc/mostpopular/v2/viewed/30.json?api-key=GNBAPNYkR2n0GXL0lkoafl1qyKNMaGXa';

    /**
     * Parse articles received from New York Times endpoint
     *
     * @return void
     * @throws \Exception
     **/

    public function fetch(): void
    {
        try {
            $request = Http::get(self::URL);
            $response = $this->process($request);

            $result = $response['results'] ?? throw new \Exception("There was an error processing article request. Article not found");
            $data = array();
            foreach ($result as $key => $article) {
                array_push($data, new Article([
                    'source' => $article['source'] ?? null,
                    'author' => $article['byline'] ?? null,
                    'title' => $article['title'] ?? null,
                    'description' => $article['abstract'] ?? null,
                    'source_url' => $article['url'] ?? null,
                    'image_url' => $article['media'][0]['media-metadata'][0]['url'] ?? null,
                    'category' => $article['section'] ?? null,
                    'publishedAt' => $article['published_date'] ?? null,
                    'content' => $article['content'] ?? null,
                ]));
            }
            $this->save(collect($data));
            echo "Successful";
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
        }
    }
}
