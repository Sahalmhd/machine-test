<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Show the dashboard with all articles
    public function dashboard()
    {
        // Fetch all articles
        $articles = Article::all();

        // Pass articles to the view
        return view('dashboard', compact('articles'));
    }

    // Show the form for creating a new article
    public function createArticle()
    {
        $categories = Category::all(); // Get all categories for the dropdown
        $tags = Tag::all(); // Get all tags for the multi-select
        return view('create-article', compact('categories', 'tags'));
    }

    // Store a new article in the database
    public function storeArticle(Request $request)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',  // If tags are selected, they must be an array
            'tags.*' => 'exists:tags,id',  // Each tag must exist in the tags table
        ]);

        // Store the image
        $imagePath = $request->file('image')->store('article_images', 'public');

        // Create the article
        $article = Article::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        // Attach selected tags to the article
        if ($request->has('tags')) {
            $article->tags()->attach($request->tags);
        }

        return redirect()->route('dashboard')->with('success', 'Article created successfully!');
    }

    // Show the form for editing an existing article
    public function editArticle($id)
    {
        $article = Article::findOrFail($id); // Find the article by ID
        $categories = Category::all(); // Get all categories for the dropdown
        $tags = Tag::all(); // Get all tags for the multi-select

        return view('edit-article', compact('article', 'categories', 'tags'));
    }

    // Update the article in the database
    public function updateArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',  // If tags are selected, they must be an array
            'tags.*' => 'exists:tags,id',  // Each tag must exist in the tags table
        ]);

        // If a new image is uploaded, store it
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('article_images', 'public');
            $article->image = $imagePath;
        }

        // Update article details
        $article->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        // Sync selected tags with the article
        if ($request->has('tags')) {
            $article->tags()->sync($request->tags); // Sync will update the existing tags and add new ones
        }

        return redirect()->route('dashboard')->with('success', 'Article updated successfully!');
    }

    // Delete an article from the database
    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);
        
        // Delete the article's image from storage if exists
        if ($article->image && file_exists(public_path('storage/' . $article->image))) {
            unlink(public_path('storage/' . $article->image));
        }

        // Delete the article
        $article->delete();

        return redirect()->route('dashboard')->with('success', 'Article deleted successfully!');
    }

    //catogary
    public function createCategory()
    {
        return view('create-category');
    }
    
    public function categories()
    {
        $categories = Category::all(); // Fetch all categories
        return view('categories', compact('categories'));
    }
    
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id); // Find the category
        $category->delete(); // Delete the category
    
        return redirect()->route('categories')->with('success', 'Category deleted successfully!');
    }
    
    public function editCategory($id)
    {
        $category = Category::findOrFail($id); // Find the category
        return view('edit-category', compact('category'));
    }
    
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name]);
    
        return redirect()->route('categories')->with('success', 'Category updated successfully!');
    }
    
    // Show the form for creating a new tag
    public function createTag()
    {
        return view('create-tag');
    }

    // Store a new tag in the database
    public function storeTag(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create the tag
        Tag::create([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tag created successfully!');
    }
}
