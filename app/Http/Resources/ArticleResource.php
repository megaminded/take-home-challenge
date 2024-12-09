<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'source' => $this->source,
            'author' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'source_url' => $this->source_url,
            'image_url' => $this->image_url,
            'category' => $this->category,
            'publishedAt' => Carbon::parse($this->publishedAt)->toDateTimeString(),
            'content' => $this->content,
            'last_updated' => $this->updated_at,
        ];
    }
}
