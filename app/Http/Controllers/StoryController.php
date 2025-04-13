<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplaceImageRequest;
use App\Models\Story;

use App\Http\Resources\StoryResource;

use App\Http\Requests\Story\CreateStoryRequest;
use App\Http\Requests\Story\UpdateStoryRequest;
use App\Http\Resources\ShowStoryResource;
use App\Interfaces\IFileUploaderService;

class StoryController extends Controller
{


    private $fileUploaderService;

    public function __construct(IFileUploaderService $fileUploaderService)
    {
        $this->fileUploaderService = $fileUploaderService;
    }

    public function index()
    {
        return $this->ok('Stories', StoryResource::collection(Story::all()));
    }

    public function store(CreateStoryRequest $request)
    {
        $data = $request->validated();
        $story = Story::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->fileUploaderService->uploadSingleFile($story, $image, 'stories');
            }
        }

        return $this->ok('Story created', StoryResource::make($story));
    }

    public function show($id)
    {
        $story = Story::find($id);
        if ($story) {
            return $this->ok('Story', ShowStoryResource::make($story));
        }
        return $this->error('Not Found', 404);
    }

    public function update(UpdateStoryRequest $request, Story $story)
    {

        if ($story) {
            $story->update($request->all());
            return $this->noContent('Updated');
        }
        return $this->error('Not Found', 404);
    }

    public function destroy(Story $story)
    {
        if ($story) {
            $story->delete();
            $this->fileUploaderService->clearCollection($story, 'stories');

            return $this->noContent('Deleted');
        }
        return $this->error('Not Found', 404);
    }

    public function replaceImage(ReplaceImageRequest $request, Story $story)
    {
        $media = $this->fileUploaderService->replaceMedia($story, $request->file('image'), $request->media_id, 'stories');
        return $this->success('Image Replaced Successfuly', ["new_path" => $media->getUrl()], 200);
    }
}
