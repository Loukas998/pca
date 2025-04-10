<?php

namespace App\Http\Controllers;

use App\Models\Story;

use App\Http\Resources\StoryResource;
use App\Services\FileUploaderService;
use App\Http\Requests\Story\CreateStoryRequest;
use App\Http\Requests\Story\UpdateStoryRequest;

class StoryController extends Controller
{


    private $fileUploaderService;

    public function __construct(FileUploaderService $fileUploaderService)
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

        if ($request->hasFile('image')) {
            $this->fileUploaderService->uploadSingleFile($story, $request['image'], 'stories');
        }

        return $this->ok('Story created', StoryResource::make($story));
    }

    public function show($id)
    {
        $story = Story::find($id);
        if ($story) {
            return $this->ok('Story', StoryResource::make($story));
        }
        return $this->error('Not Found', 404);
    }

    public function update(UpdateStoryRequest $request, $id)
    {
        $story = Story::find($id);
        if ($story) {
            $story->update($request->all());
            if ($request->hasFile('image')) {
                $this->fileUploaderService->clearCollection($story, 'stories');
                $this->fileUploaderService->uploadSingleFile($story, $request['image'], 'stories');
            }

            return $this->noContent('Updated');
        }
        return $this->error('Not Found', 404);
    }

    public function destroy($id)
    {
        $story = Story::find($id);
        if ($story) {
            $story->delete();
            $this->fileUploaderService->clearCollection($story, 'stories');

            return $this->noContent('Deleted');
        }
        return $this->error('Not Found', 404);
    }
}
