@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Edit Discussion</h1>

    <!-- Display Validation Errors -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Discussion Form -->
    <form action="{{ route('discussions.update', $discussion->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
            <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded-lg p-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200" value="{{ old('title', $discussion->title) }}" required>
        </div>

        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-semibold mb-2">Content</label>
            <textarea name="content" id="content" rows="10" class="w-full border border-gray-300 rounded-lg p-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>{{ old('content', $discussion->content) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
            <select name="category_id" id="category" class="w-full border border-gray-300 rounded-lg p-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $discussion->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition ease-in-out duration-150">Update Discussion</button>
    </form>

    <!-- Delete Discussion Form -->
    <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST" class="mt-4">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition ease-in-out duration-150">Delete Discussion</button>
    </form>
</div>
@endsection
