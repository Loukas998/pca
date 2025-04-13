<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowStoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isAuthenticated = $request->user() !== null;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'location' => $this->location,
            'date' => $this->date,
            'content' => $this->content,
            'images' => $this->getMedia('stories')->map(function ($media) use ($isAuthenticated) {
                if ($isAuthenticated) {
                    return [
                        "id" => $media->id,
                        "url" => $media->getUrl(),
                    ];
                }
                return $media->getUrl();
            }),
        ];
    }
}
