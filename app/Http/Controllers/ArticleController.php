<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class ArticleController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $articles = Article::with('categories','tags')->get();
        return $this->apiResponse($articles, 'articles retrieved successfully', 200);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'content' => 'nullable|string',
        'categories' => 'nullable|array',
        'categories.*' => 'exists:categories,id',
        'tags' => 'nullable|array', 
        'tags.*' => 'exists:tags,id', 
    ]);

    $article = Article::create([
        'name' => $validated['name'],
        'content' => $validated['content'] ?? null,
    ]);

    if ($request->has('categories')) {
        $article->categories()->sync($validated['categories']);
    }

    if ($request->has('tags')) {
        $article->tags()->sync($validated['tags']); 
    }

    $article->load('categories', 'tags'); // تحميل الفئات والوسوم المرتبطة بالمقالة

    return $this->apiResponse($article, 'Article created successfully', 201);
}

    public function show($id)
    {
        $article = Article::with('categories', 'tags')->find($id);

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

        if ($request->has('tags')) {
            $article->tags()->sync($request->tags);
        }
    
        $article->load('categories', 'tags');
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

    public function articlesByTagName($tagName)
{
    $tag = Tag::where('name', $tagName)->first();

    if (!$tag) {
        return $this->apiResponse(null, 'Tag not found', 404);
    }

    $articles = $tag->articles;

    if ($articles->isEmpty()) {
        return $this->apiResponse(null, 'No articles found for this tag', 404);
    }

    return $this->apiResponse($articles, 'Articles retrieved successfully', 200);
}

}
