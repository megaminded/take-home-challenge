<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'source',
        'author',
        'title',
        'description',
        'source_url',
        'image_url',
        'category',
        'publishedAt',
        'content',
    ];
}
