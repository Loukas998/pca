<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        return $this->ok('Categories', CategoryResource::collection(Category::all()));
    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());
        return $this->ok('Category created', CategoryResource::make($category));
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return $this->ok('Category', CategoryResource::make($category));
        }
        return $this->error('Not Found', 404);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->update($request->all());
            return $this->noContent('Updated');
        }
        return $this->error('Not Found', 404);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return $this->noContent('Deleted');
        }
        return $this->error('Not Found', 404);
    }
}
