<?php

namespace App\Http\Controllers;

use App\Services\FileUploaderService;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;


class ProjectController extends Controller
{


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
        if ($project) {
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
        if ($project) {
            $project->update($request->all());
            if ($request->hasFile('images')) {
                $this->fileUploaderService->clearCollection($project, 'projects');

                foreach ($request->file('images') as $image) {
                    $this->fileUploaderService->uploadSingleFile($project, $image, 'projects');
                }
            }

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
}
