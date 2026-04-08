<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Post: {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT') 
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                        <input type="text" name="title" value="{{ $post->title }}" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    </div>

                    @if($post->image)
                        <div class="mb-4">
                            <p class="block text-gray-700 text-sm font-bold mb-2">Current Image</p>
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-32 h-32 object-cover rounded shadow-sm">
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Change Image (Leave blank to keep current)</label>
                        <input type="file" name="image" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                        <textarea name="content" rows="8" class="shadow border rounded w-full py-2 px-3 text-gray-700">{{ $post->content }}</textarea>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Post
                        </button>
                        <a href="{{ route('posts.show', $post) }}" class="text-gray-500 hover:underline text-sm">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>