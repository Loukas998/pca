<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Spatie\ImageOptimizer\OptimizerChainFactory;



class FileUploaderService
{
    public function uploadSingleFile(Model $model, UploadedFile $file, string $collectionName = 'default') : Media
    {
        return $model->addMedia($file)->toMediaCollection($collectionName);
    }

    public function uploadMultipleFiles(Model $model, array $files, string $collectionName = 'default') : array
    {
        $uploadedMedia = [];
        foreach($files as $file)
        {
            $uploadedMedia[] = $model->addMedia($file)->toMediaCollection($collectionName);
        }
        
        return $uploadedMedia;
    }

    public function clearCollection(Model $model, string $collectionName = 'default'): void
    {
        $model->clearMediaCollection($collectionName);
    }
}