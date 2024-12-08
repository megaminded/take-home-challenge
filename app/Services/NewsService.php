<?php

namespace App\Services;

use App\DataSource;
use App\Models\Article;
use App\Interface\INewsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

class NewsService implements INewsService
{
    /**
     * Save a articles received from defined sources
     *
     * @param Collection<Article> $articles An array of Article objects
     * @return void
     * @throws exception
     **/

    public function save(Collection $articles): void
    {
        try {
            DB::beginTransaction();
            // Update existing articles and insert new articles at once using the source url as a unique key
            if ($count = Article::upsert($articles->toArray(), ['source_url'])) {
                Log::info($count . " articles saved");
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new \Exception($ex->getMessage());
        }
    }
    public function process(Response $response): array | bool
    {
        if ($response->successful()) {
            $result = $response->json();
            return $result;
        } else {
            Log::critical($response['fault']['faultstring'] ?? "An error occurred while processing request.");
            return false;
        }
    }
}
