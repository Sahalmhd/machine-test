<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function dashboard()
    {
        $articles = Article::all();
        return view('dashboard', compact('articles'));
    }

    public function createArticle()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('create-article', compact('categories', 'tags'));
    }

    public function storeArticle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        $imagePath = $request->file('image')->store('article_images', 'public');

        $article = Article::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        if ($request->has('tags')) {
            $article->tags()->attach($request->tags);
        }

        return redirect()->route('dashboard')->with('success', 'Article created successfully!');
    }

    public function editArticle($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        return view('edit-article', compact('article', 'categories', 'tags'));
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('article_images', 'public');
            $article->image = $imagePath;
        }

        $article->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        if ($request->has('tags')) {
            $article->tags()->sync($request->tags);
        }

        return redirect()->route('dashboard')->with('success', 'Article updated successfully!');
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);

        if ($article->image && file_exists(public_path('storage/' . $article->image))) {
            unlink(public_path('storage/' . $article->image));
        }

        $article->delete();

        return redirect()->route('dashboard')->with('success', 'Article deleted successfully!');
    }
}
