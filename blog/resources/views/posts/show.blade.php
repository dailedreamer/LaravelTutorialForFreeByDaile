<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $post->title }}
            </h2>
            <a href="{{ route('posts.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-bold">
                &larr; Back to Feed
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded text-sm">
                            Edit
                        </a>

                        <form method="POST" action="{{ route('posts.destroy', $post) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded text-sm" onclick="return confirm('Are you sure you want to delete this post?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                
                <p class="text-sm text-gray-500 mb-6">Published {{ $post->created_at->format('M j, Y') }}</p>
                
                <div class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $post->content }}</div>

            </div>
        </div>
    </div>
</x-app-layout>