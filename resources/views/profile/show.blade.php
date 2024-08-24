@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Profile Header -->
    <div class="flex items-center space-x-4 mb-8">
        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full border-2 border-gray-200">
        <div>
            <h1 class="text-3xl font-bold">{{ $user->name }}'s Profile</h1>
            <p class="text-gray-600 mt-1">Email: {{ $user->email }}</p>
            <p class="text-gray-600">Address: {{ $user->address }}</p>
        </div>
    </div>

    <!-- Recent Posts -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">Recent Posts</h2>
        @if($user->posts->count())
            <ul class="space-y-4">
                @foreach($user->posts as $post)
                    <li class="bg-white shadow rounded-md p-4">
                        <a href="{{ route('discussions.show', $post->discussion) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                            {{ $post->discussion->title }}
                        </a>
                        <p class="mt-2 text-gray-700">{{ $post->content }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No recent posts found.</p>
        @endif
    </div>
</div>
@endsection
