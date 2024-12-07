<?php

namespace App\Interface;

use App\DataSource;
use Illuminate\Http\Client\Response;

interface INews
{
    function save(array $articles);
    function process(Response $response): array | bool;
}
