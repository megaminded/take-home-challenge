<?php

namespace App\Services;

use App\DataSource;
use App\Interface\INews;
use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class News implements INews
{
    public function save(array $articles)
    {
        $result = Article::upsert($articles, ['source']);
    }
    public function update(array $articles)
    {
        $result = Article::upsert($articles, ['source']);
    }
}
