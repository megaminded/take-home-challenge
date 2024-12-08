<?php

namespace App\Interface;

use App\DataSource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\Response;

interface INewsService
{
    function save(Collection $articles): void;
    function process(Response $response): array | bool;
}
