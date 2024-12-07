<?php

namespace App\Services;

use App\DataSource;
use App\Interface\IArticleSource;
use App\Services\News;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

final class NewYorkTimes extends News implements IArticleSource
{
    /**
     * Handle articles received from New York Times endpoint
     *
     * @return void
     * @throws \Exception
     **/

    public function fetch(): void
    {
        try {
            $url = DataSource::NYK->value . env('NYK_API_KEY');
            $request = Http::get($url);
            $response = $this->process($request);

            $result = $response['results'] ?? throw new \Exception("There was an error processing article request. Article not found");
            $data = array();
            foreach ($result as $key => $article) {
                array_push($data, [
                    'source' => $article['source'] ?? null,
                    'author' => $article['byline'] ?? null,
                    'title' => $article['title'] ?? null,
                    'description' => $article['abstract'] ?? null,
                    'source_url' => $article['url'] ?? null,
                    'image_url' => $article['media'][0]['media-metadata'][0]['url'] ?? null,
                    'category' => $article['section'] ?? null,
                    'publishedAt' => $article['published_date'] ?? null,
                    'content' => $article['content'] ?? null,
                ]);
            }
            $this->save($data);
            echo "Successful";
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
        }
    }
}
