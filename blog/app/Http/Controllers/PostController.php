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

    // 4. READ (Single): Show one specific post
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // 5. UPDATE (Show the form): Load the edit screen with the current data
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // 6. UPDATE (Save the data): Validate and save the new changes
    public function update(Request $request, Post $post)
    {
        // 1. Validate to ensure the updated fields aren't completely blank
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // 2. Save the new data to the database
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // 3. Send the user back to read the freshly updated post
        return redirect()->route('posts.show', $post); 
    }

    // 7. DELETE: Nuke it from the database completely
    public function destroy(Post $post)
    {
        $post->delete();

        // Send them back to the main feed since the post no longer exists
        return redirect()->route('posts.index'); 
    }
}