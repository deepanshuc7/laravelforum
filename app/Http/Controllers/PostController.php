<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use HTMLPurifier;
use HTMLPurifier_Config;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'content' => 'required|string',
            'discussion_id' => 'required|exists:discussions,id',
        ]);

        // Configure and initialize HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Sanitize the content
        $cleanContent = $purifier->purify($request->input('content'));

        // Create a new post
        Post::create([
            'content' => $cleanContent,
            'discussion_id' => $request->input('discussion_id'),
            'user_id' => Auth::id(),
        ]);

        // Redirect to the discussion page with a success message
        return redirect()->route('discussions.show', $request->input('discussion_id'))
                         ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post): View
    {
        // Check if the user can update the post
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        // Check if the user can update the post
        $this->authorize('update', $post);

        // Validate the request
        $request->validate([
            'content' => 'required|string',
        ]);

        // Configure and initialize HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Sanitize the content
        $cleanContent = $purifier->purify($request->input('content'));

        // Update the post
        $post->update([
            'content' => $cleanContent,
        ]);

        // Redirect to the discussion page with a success message
        return redirect()->route('discussions.show', $post->discussion_id)
                         ->with('status', 'Post updated successfully');
    }

    public function destroy(Post $post): RedirectResponse
    {
        // Check if the user can delete the post
        $this->authorize('delete', $post);

        // Delete the post
        $post->delete();

        // Redirect to the discussion page with a success message
        return redirect()->route('discussions.show', $post->discussion_id)
                         ->with('status', 'Post deleted successfully');
    }
}
