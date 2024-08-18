<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $categories = Category::with('articles')->get();

        return $this->apiResponse($categories, 'ok', 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([$request->all()]);

        if ($category) {
            return $this->apiResponse($category, 'category saved successfully', 201);
        }
        return $this->apiResponse(null, 'category not save', 400);
    }

    public function show($id)
    {
        $category = Category::with('articles')->find($id);

        if ($category) {
            return $this->apiResponse($category, 'category retrieved successfully', 200);
        }

        return $this->apiResponse(null, 'category not found', 404);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->apiResponse(null, 'category not found', 404);
        }

        $category->update($request->all());
       if($category){
        return $this->apiResponse($category, 'category updated successfully', 200);
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->apiResponse(null, 'category not found', 404);
        }

        $category->delete($id);
        if($category){
            return $this->apiResponse(null, 'category deleted successfully', 200);
        }
    }
}

