<?php
namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function create()
    {
        return view('create-tag');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Tag::create(['name' => $request->name]);

        return redirect()->route('dashboard')->with('success', 'Tag created successfully!');
    }
}
