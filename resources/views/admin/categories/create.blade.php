@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Create New Category</h1>

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

    <!-- Create Category Form -->
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
       
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Category Name</label>
            <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg p-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150">
            Create Category
        </button>
    </form>
</div>
@endsection
