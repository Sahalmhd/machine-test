<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    // Display a listing of tags
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index', compact('tags'));
    }

    // Show the form for creating a new tag
    public function create()
    {
        return view('tags.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);
    
        try {
            Tag::create([
                'name' => $request->name,
            ]);
    
            return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tags.create')->withErrors('Failed to create tag: ' . $e->getMessage());
        }
    }
    

    // Show the form for editing the specified tag
    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    // Update the specified tag in storage
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        $tag->update($request->all());
        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    // Remove the specified tag from storage
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }
}
