<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class ArticleController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $articles = Article::with('categories')->get();
        return $this->apiResponse($articles, 'articles retrieved successfully', 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $article = Article::create($validated);

        if ($request->has('categories')) {
            $article->categories()->sync($validated['categories']);
        }

        $article->load('categories');
        return $this->apiResponse($article, 'Article created successfully', 201);
    }

    public function show($id)
    {
        $article = Article::with('categories')->find($id);

        if (!$article) {
            return $this->apiResponse(null, 'Article not found', 404);
        }

        return $this->apiResponse($article, 'Article retrieved successfully', 200);
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return $this->apiResponse(null, 'Article not found', 404);
        }

        $article->update($request->all());

        if ($request->has('categories')) {
            $article->categories()->sync($request->categories);
        }

        $article->load('sports');
        return $this->apiResponse($article, 'Article updated successfully', 200);
    }

    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return $this->apiResponse(null, 'Article not found', 404);
        }

        $article->delete($id);
        if($article)
        return $this->apiResponse(null ,'the Article delete ',200);
    }

    public function articlesByCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return $this->apiResponse(null, 'category not found', 404);
        }

        $articles = $category->articles;

        if ($articles->isEmpty()) {
            return $this->apiResponse(null, 'No articles found for this category', 404);
        }
        return $this->apiResponse($articles, 'articles retrieved successfully', 200);
    }
}
