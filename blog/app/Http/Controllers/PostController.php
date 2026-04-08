<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 1. READ: Show all posts
    public function index()
    {
        $posts = Post::latest()->get(); // Fetch all posts from the database, newest first
        return view('posts.index', compact('posts')); // Send them to a view
    }

    // 2. CREATE: Show the form to write a new post
    public function create()
    {
        return view('posts.create');
    }

    // 3. CREATE (Save the data): Catch the form submission and save it
    public function store(Request $request)
    {
        // 1. Validate the data (make sure the user actually typed something)
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // 2. Create the post in the database
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // 3. Send the user back to the feed with a success message
        return redirect()->route('posts.index');
    }
}