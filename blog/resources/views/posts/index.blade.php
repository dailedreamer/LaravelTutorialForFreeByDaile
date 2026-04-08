<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Daily Life Blog
            </h2>
            <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                + New Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @foreach ($posts as $post)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        @if($post->image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="rounded-lg w-full h-64 object-cover">
                            </div>
                        @endif
                        <h3 class="font-bold text-2xl mb-2 text-blue-600 hover:underline">
                            <a href="{{ route('posts.show', $post) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="text-gray-700">{{ $post->content }}</p>
                        <p class="text-sm text-gray-400 mt-4">Posted: {{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>