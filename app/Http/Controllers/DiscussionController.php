<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use HTMLPurifier;
use HTMLPurifier_Config;

class DiscussionController extends Controller
{
    use AuthorizesRequests;

    /**
     * Show the form for creating a new discussion.
     *
     * @return \Illuminate\Http\Response
     */

     public function search(Request $request)
    {
        $query = $request->input('query');

        // Search discussions by title or content
        $discussions = Discussion::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->latest()
            ->get();

        return view('home', compact('discussions'));
    }
    public function create()
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to create a discussion.');
        }

        // Fetch categories for the create form
        $categories = Category::all();

        return view('discussions.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        // Configure and initialize HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Sanitize the content
        $cleanContent = $purifier->purify($request->input('content'));

        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string', // The raw content is validated here but cleaned before saving
            'category_id' => 'required|exists:categories,id',
        ]);

        // Create a new discussion
        $discussion = Discussion::create([
            'title' => $request->input('title'),
            'content' => $cleanContent, // Use the sanitized content
            'category_id' => $request->input('category_id'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('discussions.show', $discussion->id)
                         ->with('success', 'Discussion created successfully.');
    }

   
    public function show(Discussion $discussion)
    {
        // Load related posts
        $posts = $discussion->posts()->orderBy('created_at', 'desc')->get();

        return view('discussions.show', compact('discussion', 'posts'));
    }

    public function edit(Discussion $discussion)
    {
         
        // Ensure the user is authorized to edit the discussion
        $this->authorize('update', $discussion);

        // Fetch categories for the edit form
        $categories = Category::all();

         // Strip HTML tags from the content
        $discussion->content = strip_tags($discussion->content);
        $discussion->content = htmlspecialchars($discussion->content, ENT_QUOTES, 'UTF-8');

        return view('discussions.edit', compact('discussion', 'categories'));
    }

   
    public function update(Request $request, Discussion $discussion)
    {
        // Ensure the user is authorized to update the discussion
        $this->authorize('update', $discussion);

        // Configure and initialize HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Sanitize the content
        $cleanContent = $purifier->purify($request->input('content'));

        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string', // The raw content is validated here but cleaned before saving
            'category_id' => 'required|exists:categories,id',
        ]);

        // Update the discussion
        $discussion->update([
            'title' => $request->input('title'),
            'content' => $cleanContent, // Use the sanitized content
            'category_id' => $request->input('category_id'),
        ]);

        return redirect()->route('discussions.show', $discussion->id)
                         ->with('success', 'Discussion updated successfully.');
    }

    
    public function destroy(Discussion $discussion)
    {
        // Ensure the user is authorized to delete the discussion
        $this->authorize('delete', $discussion);

        // Delete the discussion
        $discussion->delete();

        return redirect()->route('home')
                         ->with('success', 'Discussion deleted successfully.');
    }
}
