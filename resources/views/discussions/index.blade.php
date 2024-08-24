@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Display success messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Page Title -->
    <h1 class="text-3xl font-bold mb-6">All Discussions</h1>

    <!-- Discussions List -->
    @if ($discussions->count())
        <div class="space-y-4">
            @foreach ($discussions as $discussion)
                <a href="{{ route('discussions.show', $discussion->id) }}" class="block bg-white p-6 rounded-lg shadow-md hover:bg-gray-100 transition duration-150 ease-in-out">
                    <h5 class="text-xl font-semibold mb-2">{{ $discussion->title }}</h5>
                    <p class="text-gray-700 mb-2">{{ Str::limit($discussion->content, 100) }}</p>
                    <div class="text-sm text-gray-500">
                        <span>Category: <span class="font-medium">{{ $discussion->category->name }}</span></span> |
                        <span> Posted by <span class="font-medium">{{ $discussion->user->name }}</span></span>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $discussions->links('pagination::tailwind') }}
        </div>
    @else
        <p class="text-gray-500">No discussions found.</p>
    @endif

    <!-- Link to create a new discussion -->
    <div class="mt-8">
        <a href="{{ route('discussions.create') }}" class="inline-block bg-blue-500 text-white px-6 py-3 rounded-md shadow hover:bg-blue-600 transition duration-150 ease-in-out">Create New Discussion</a>
    </div>
</div>
@endsection
