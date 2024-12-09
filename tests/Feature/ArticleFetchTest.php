<?php

use App\Models\Article;
use App\Services\NewsAPI;
use App\Services\TheGuardian;
use App\Services\NewYorkTimes;

test('if articles can be fetched from the various sources', function () {
    $sources  = [
        new NewsAPI(),
        new NewYorkTimes(),
        new TheGuardian()
    ];
    foreach ($sources as $source) {
        $source->fetch();
    }
    expect(Article::count())->not()->toBeNull();
});
