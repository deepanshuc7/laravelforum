@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-4 px-4">
    
    <h1 class="text-3xl font-bold mb-4">Welcome to the Forum</h1>

    

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <!-- Categories Section -->
        <div>
            <h2 class="text-2xl font-semibold mb-2">Categories</h2>
            <ul class="space-y-2">
                @foreach($categories as $category)
                    <li class="bg-white shadow rounded-md p-4">
                        <a href="{{ route('categories.show', $category->id) }}" class="text-blue-500 hover:underline">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Recent Discussions Section -->
        <div>
            <h2 class="text-2xl font-semibold mb-2">Recent Discussions</h2>
            <ul class="space-y-2">
                @foreach($recentDiscussions as $discussion)
                    <li class="bg-white shadow rounded-md p-4">
                        <a href="{{ route('discussions.show', $discussion->id) }}" class="text-blue-500 hover:underline">
                            {{ $discussion->title }}
                        </a>
                        <p class="text-gray-600 mt-2">{{ Str::limit($discussion->content, 100) }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>



@endsection
