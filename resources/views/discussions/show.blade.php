@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <!-- Discussion Title -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">{{ $discussion->title }}</h1>
        <!-- Edit/Delete Discussion Buttons -->
        @canany(['update', 'delete'], $discussion)
            <div class="flex space-x-4">
                @can('update', $discussion)
                    <a href="{{ route('discussions.edit', $discussion->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm leading-tight rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a3 3 0 114.242 4.242l-8.485 8.485a3 3 0 01-1.414.707l-3 1a1 1 0 01-1.264-1.264l1-3a3 3 0 01.707-1.414l8.485-8.485z"></path></svg>
                        Edit
                    </a>
                @endcan
                @can('delete', $discussion)
                    <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold text-sm leading-tight rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m4 4H6"></path></svg>
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        @endcanany

        @if(auth()->user()->is_admin)
            <div class="flex space-x-4">
                <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold text-sm leading-tight rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m4 4H6"></path></svg>
                        Admin Delete
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Main Post Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold">Original Post</h2>
        <p class="mt-4 text-gray-700">{{ $discussion->content }}</p>
        <div class="mt-6 flex justify-between items-center text-gray-500">
            <span>Posted by {{ $discussion->user->name }}</span>
            <span>{{ $discussion->created_at ? $discussion->created_at->format('M d, Y') : 'Date not available' }}</span>
        </div>
    </div>

    <!-- Replies Section -->
    <h2 class="text-2xl font-semibold mb-4">Replies</h2>
    <div class="space-y-6">
        @foreach($discussion->posts as $post)
            <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                <p class="text-gray-800">{!! $post->content !!}</p>
                <div class="mt-4 flex justify-between items-center text-gray-500">
                    <span>Reply by {{ $post->user->name }}</span>
                    <span>{{ $post->created_at ? $post->created_at->format('M d, Y') : 'Date not available' }}</span>
                </div>
                <!-- Edit/Delete Buttons for Replies -->
                @canany(['update', 'delete'], $post)
                    <div class="mt-2 flex space-x-4">
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm leading-tight rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a3 3 0 114.242 4.242l-8.485 8.485a3 3 0 01-1.414.707l-3 1a1 1 0 01-1.264-1.264l1-3a3 3 0 01.707-1.414l8.485-8.485z"></path></svg>
                                Edit
                            </a>
                        @endcan
                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold text-sm leading-tight rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m4 4H6"></path></svg>
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                @endcanany

                @if(auth()->user()->is_admin)
                    <div class="mt-2 flex space-x-4">
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold text-sm leading-tight rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m4 4H6"></path></svg>
                                Admin Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Add Reply Form -->
    <div class="mt-10">
        <h3 class="text-xl font-semibold mb-4">Add a Reply</h3>
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <input type="hidden" name="discussion_id" value="{{ $discussion->id }}">
            <div class="mb-4">
                <label for="content" class="block text-gray-700">Content</label>
                <textarea name="content" id="content" class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:border-indigo-500 focus:ring-indigo-500" rows="5" required></textarea>
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Submit Reply</button>
        </form>
    </div>
</div>
@endsection
