<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

interface IFileUploaderService
{
    public function uploadSingleFile(Model $model, UploadedFile $file, string $collectionName = 'default'): Media;
    public function uploadMultipleFiles(Model $model, array $files, string $collectionName = 'default'): array;
    public function clearCollection(Model $model, string $collectionName = 'default'): void;
    public function replaceMedia(Model $model, UploadedFile $newFile, int $mediaId, string $collectionName = 'default'): Media;
}
