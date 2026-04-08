<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        // 1. Validate the data (Added image validation!)
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480', // 20MB max
        ]);

        // 2. Handle the Image Upload
        $imagePath = null; // Default to null if they don't upload a picture
        
        if ($request->hasFile('image')) {
            // Grab the file, save it in the 'posts' folder on the 'public' disk
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // 3. Create the post in the database (Now including the image path!)
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        // 4. Send the user back to the feed
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
        // This is where the check belongs!
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    // 6. UPDATE (Save the data): Validate and save the new changes
    public function update(Request $request, Post $post)
    {
        // 1. Validate
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:20480', // 20MB limit
        ]);

        // 2. Prepare the data to update
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ];

        // 3. If a NEW image is uploaded, save it and add to the data array
        if ($request->hasFile('image')) {
            // Store the new image
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        // 4. Update the record in the database
        $post->update($data);

        // 5. Send them back to the post with a success message
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