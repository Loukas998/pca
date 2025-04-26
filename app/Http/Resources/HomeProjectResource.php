<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeProjectResource extends JsonResource
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
            'id'        => $this->id,
            'title'     => $this->title,
            'order'     => $this->order,
            'images' => $this->getMedia('home_projects')->map(function ($media) use ($isAuthenticated) {
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
