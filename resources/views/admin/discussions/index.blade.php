@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Manage Discussions</h1>

    <!-- Check for success messages -->
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Title</th>
                <th class="py-2 px-4 border-b">Created At</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($discussions as $discussion)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $discussion->title }}</td>
                    <td class="py-2 px-4 border-b">{{ $discussion->created_at->format('M d, Y') }}</td>
                    <td class="py-2 px-4 border-b">
                        <!-- Link to view the discussion -->
                        <a href="{{ route('discussions.show', $discussion->id) }}" class="text-blue-600 hover:text-blue-800 mr-4">View</a>

                        <!-- Form to delete the discussion -->
                        <form action="{{ route('admin.discussions.destroy', $discussion->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
