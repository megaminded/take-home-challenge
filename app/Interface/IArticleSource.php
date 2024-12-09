<?php

namespace App\Interface;

use App\Models\Article;

interface IArticleSource
{
    function fetch(): void;
    function parse(array $article): Article;
}
