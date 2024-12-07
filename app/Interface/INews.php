<?php

namespace App\Interface;

use App\DataSource;

interface INews
{
    function save(array $articles);
    function update(array $articles);
}
