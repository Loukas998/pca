<?php

namespace App\Http\Controllers;

use App\Http\Resources\HomeProjectResource;
use App\Models\HomeProject;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;


class HomeProjectController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->ok('Home page projects', HomeProjectResource::collection(HomeProject::with('project')->orderBy('order')->get()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'string|required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'order' => 'integer|required'
        ]);

        $homeProject = HomeProject::create($data);

        if ($request->hasFile('image')) {
            $homeProject->addMediaFromRequest('image')->toMediaCollection('home_projects');
        }
        
        return $this->ok('Project added to home page', HomeProjectResource::make($homeProject));
    }

    public function update(Request $request, $id)
    {
        $homeProject = HomeProject::find($id);
        if($homeProject)
        {
            $homeProject->update($request->all());
            return $this->noContent('Updated');
        }
        return $this->error('Not Found', 404);
    }

    public function destroy($id)
    {
        $homeProject = HomeProject::find($id);
        if($homeProject)
        {
            $homeProject->delete();
            return $this->noContent('Deleted');
        }
        return $this->error('Not Found', 404);
    }
}
