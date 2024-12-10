<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $categories = Category::paginate(10); // Paginate the categories
        return view('categories.index', compact('categories'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
    
        try {
            Category::create([
                'name' => $request->name,
            ]);
    
            return redirect()->route('categories.index')->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('categories.create')->withErrors('Failed to create category: ' . $e->getMessage());
        }
    }
    
    // Display the specified resource.
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
