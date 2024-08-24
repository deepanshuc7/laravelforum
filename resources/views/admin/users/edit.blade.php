@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Edit User</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
            <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg p-2" value="{{ $user->name }}" required>
        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-lg p-2" value="{{ $user->email }}" required>
        </div>

        <!-- Admin Status Field -->
        <div class="mb-4">
            <label for="is_admin" class="block text-gray-700 font-semibold mb-2">Admin</label>
            <select name="is_admin" id="is_admin" class="w-full border border-gray-300 rounded-lg p-2">
                <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700">Update User</button>
    </form>
</div>
@endsection
