<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Story extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['created_at', 'updated_at'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('stories')->singleFile();
    }
}
