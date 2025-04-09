<?php

namespace App\Http\Controllers;

use App\Services\FileUploaderService;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Models\Story;

class ProjectController extends Controller
{
    use ApiResponse;

    private $fileUploaderService;

    public function __construct(FileUploaderService $fileUploaderService)
    {
        $this->fileUploaderService = $fileUploaderService;
    }

    public function index()
    {
        return $this->ok('Projects', ProjectResource::collection(Project::all()));
    }

    public function show($id)
    {
        $project = Project::find($id);
        if($project)
        {
            return $this->ok('Project', ProjectResource::make($project));
        }
        return $this->error('Not Found', 404);
    }
    
    public function store(CreateProjectRequest $request)
    {
        $data = $request->validated();
        $project = Project::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->fileUploaderService->uploadSingleFile($project, $image, 'projects');
            }
        }

        return $this->ok('Project created', ProjectResource::make($project));
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $project = Project::find($id);
        if($project)
        {
            if ($request->has('replacements')) {
                foreach ($request->input('replacements') as $index => $replacement) {
                    $mediaId = $replacement['media_id'];
                    $imageFile = $request->file("replacements.{$index}.file");
                    
                    if ($imageFile && $mediaId) {
                        $mediaItem = $project->media()->find($mediaId);
                        if ($mediaItem) {
                            // Delete old media
                            $mediaItem->delete();
                            
                            // Add new media
                            $this->fileUploaderService->uploadSingleFile(
                                $project, 
                                $imageFile, 
                                'projects'
                            );
                        }
                    }
                }
            }
            return $this->noContent('Updated');
        }
        return $this->error('Not Found', 404);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        if($project)
        {
            $project->delete();
            $this->fileUploaderService->clearCollection($project, 'projects');
            
            return $this->noContent('Deleted');
        }
        return $this->error('Not Found', 404);
    }
}
