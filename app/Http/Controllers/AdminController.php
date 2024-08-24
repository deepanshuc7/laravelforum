<?php

namespace App\Http\Controllers;

use App\Notifications\ProfileDeleted;
use App\Notifications\ProfileEdited;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Discussion;
use App\Models\Comment;
use App\Models\Category; // Ensure you have the Category model
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Existing methods...

    // User Management Methods
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'required|boolean',
        ]);

        // Update the user's information
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->is_admin = $request->input('is_admin');
        $user->save();

        Notification::send($user, new ProfileEdited());

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $userEmail = $user->email;

        $user->delete();

        Notification::route('mail', $userEmail)->notify(new ProfileDeleted());
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');

    }

    public function deleteDiscussion(Discussion $discussion)
    {
        $discussion->delete();
        return redirect()->route('home')->with('success', 'Discussion deleted successfully.');
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    // Discussion Management Methods
    public function manageDiscussions()
    {
        $discussions = Discussion::all(); 
        return view('admin.discussions.index', compact('discussions'));
    }

    // Category Management Methods
    public function categoriesIndex()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
