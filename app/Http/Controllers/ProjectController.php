<?php

namespace App\Http\Controllers;


use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Requests\ReplaceImageRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ShowProjectResource;
use App\Interfaces\IFileUploaderService;
use App\Models\Project;


class ProjectController extends Controller
{


    private $fileUploaderService;

    public function __construct(IFileUploaderService $fileUploaderService)
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
        if ($project) {
            return $this->ok('Project', ShowProjectResource::make($project));
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
        if ($project) {
            $project->update($request->validated());
            return $this->noContent('Updated');
        }
        return $this->error('Not Found', 404);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        if ($project) {
            $project->delete();
            $this->fileUploaderService->clearCollection($project, 'projects');

            return $this->noContent('Deleted');
        }
        return $this->error('Not Found', 404);
    }


    public function replaceImage(ReplaceImageRequest $request, Project $project)
    {
        $media = $this->fileUploaderService->replaceMedia($project, $request->file('image'), $request->media_id, 'projects');
        return $this->success('Image Replaced Successfuly', ["new_path" => $media->getUrl()], 200);
    }
}
