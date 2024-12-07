<?php

namespace App\Services;

use App\DataSource;
use App\Models\Article;
use App\Services\NewsService;
use App\Interface\IArticleSource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

final class TheGuardian extends NewsService implements IArticleSource
{
    // Data Source
    const NAME = DataSource::THE_GUARDIAN->value;

    // The API key is hardcoded here for simplicity and quick access during development.
    // For production or sensitive applications, I avoid hardcoding API keys or secrets directly in the codebase.
    const URL = "https://content.guardianapis.com/search?page-size=20&show-fields=all&api-key=3f0a4859-09dd-4439-81fa-fca11b2e4bf3";

    public function fetch(): void
    {
        try {
            $request = Http::get(self::URL);
            $response = $this->process($request);
            $result = $response['response']['results'] ?? throw new \Exception("There was an error processing article request. Article not found");
            $data = array();
            foreach ($result as $key => $article) {
                array_push($data, new Article([
                    'source' => $article['fields']['publication'] ?? null,
                    'author' => $article['fields']['byline'] ?? null,
                    'title' => $article['fields']['headline'] ?? null,
                    'description' => $article['fields']['trailText'] ?? null,
                    'source_url' => $article['webUrl'],
                    'image_url' => $article['fields']['thumbnail'] ?? null,
                    'category' => $article['sectionName'] ?? null,
                    'publishedAt' => $article['webPublicationDate'] ?? null,
                    'content' => $article['fields']['bodyText'] ?? null,
                ]));
            }
            $this->save(collect($data));
            echo "Successful";
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
        }
    }
}
