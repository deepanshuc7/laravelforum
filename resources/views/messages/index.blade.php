<!-- resources/views/messages/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Messages</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Message Sending Form -->
    <form action="{{ route('messages.store') }}" method="POST" class="mb-6">
        @csrf

        <div class="mb-4">
            <label for="receiver_id" class="block text-gray-700 font-semibold mb-2">Send to</label>
            <select name="receiver_id" id="receiver_id" class="w-full border border-gray-300 rounded-lg p-2" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="message" class="block text-gray-700 font-semibold mb-2">Message</label>
            <textarea name="message" id="message" class="w-full border border-gray-300 rounded-lg p-2" rows="4" required></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Send Message</button>
    </form>

    <!-- Message History -->
    <div class="border-t border-gray-300 pt-4">
        <h2 class="text-2xl font-semibold mb-4">Message History</h2>
        @foreach($messages as $message)
            <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                <strong>{{ $message->sender->name }}:</strong>
                <p>{{ $message->message }}</p>
                <small class="text-gray-500">{{ $message->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>
</div>
@endsection
