@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Page Title -->
    <h1 class="text-3xl font-bold mb-6">Discussions in Category: {{ $category->name }}</h1>

    <!-- Discussions List -->
    @if($discussions->count())
        <ul class="space-y-4">
            @foreach($discussions as $discussion)
                <li class="bg-white shadow rounded-md p-4">
                    <a href="{{ route('discussions.show', $discussion->id) }}" class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                        {{ $discussion->title }}
                    </a>
                    <p class="mt-2 text-gray-600">{{ Str::limit($discussion->content, 100) }}</p>
                </li>
            @endforeach
        </ul>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $discussions->links('pagination::tailwind') }}
        </div>
    @else
        <p class="text-gray-500">No discussions found in this category.</p>
    @endif
</div>
@endsection
