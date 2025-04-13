<?php

namespace App\Services;

use App\Interfaces\IFileUploaderService;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;



class FileUploaderService implements IFileUploaderService
{
    public function uploadSingleFile(Model $model, UploadedFile $file, string $collectionName = 'default'): Media
    {
        return $model->addMedia($file)->toMediaCollection($collectionName);
    }

    public function uploadMultipleFiles(Model $model, array $files, string $collectionName = 'default'): array
    {
        $uploadedMedia = [];
        foreach ($files as $file) {
            $uploadedMedia[] = $model->addMedia($file)->toMediaCollection($collectionName);
        }

        return $uploadedMedia;
    }

    public function clearCollection(Model $model, string $collectionName = 'default'): void
    {
        $model->clearMediaCollection($collectionName);
    }

    public function replaceMedia(Model $model, UploadedFile $newFile, int $mediaId, string $collectionName = 'default'): Media
    {

        $media = $model->media()
            ->where('id', $mediaId)
            ->where('collection_name', $collectionName)
            ->first();


        $currentFilePath = $media->getPath();

        if (! file_exists($currentFilePath)) {

            throw new \Exception("File not found at path: {$currentFilePath}");
        }


        file_put_contents($currentFilePath, file_get_contents($newFile->getRealPath()));

        $media->update([
            'file_name' => $newFile->getClientOriginalName(),
            'mime_type' => $newFile->getMimeType(),
            'size'      => $newFile->getSize(),
        ]);


        return $media;
    }
}
