<?php

// namespace App\Http\Controllers;

// use App\Models\Category;
// use App\Models\Discussion;
// use Illuminate\Http\Request;

// class CategoryController extends Controller
// {
//     /**
//      * Display the homepage with categories and recent discussions.
//      *
//      * @return \Illuminate\View\View
//      */
//     public function index()
//     {
//         // Fetch all categories
//         $categories = Category::all();

//         // Fetch recent discussions (e.g., last 5 discussions)
//         $recentDiscussions = Discussion::latest()->take(5)->get();

//         // Return the view with categories and recent discussions
//         return view('home', compact('categories', 'recentDiscussions'));
//     }

//     /**
//      * Display the specified category with all its discussions.
//      *
//      * @param  \App\Models\Category  $category
//      * @return \Illuminate\View\View
//      */
//     public function show(Category $category)
//     {
//         // Fetch discussions in this category, sorted by newest first
//         $discussions = $category->discussions()->latest()->paginate(10);

//         // Return the view with category and its discussions
//         return view('categories.show', compact('category', 'discussions'));
//     }
// }

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display the homepage with categories and recent discussions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all categories
        $categories = Category::all();

        // Fetch recent discussions (e.g., last 5 discussions)
        $recentDiscussions = Discussion::latest()->take(5)->get();

        // Check if the user is an admin
        if (Auth::check() && Auth::user()->is_admin) {
            // Admin view
            return view('admin.categories.index', compact('categories', 'recentDiscussions'));
        }

        // Non-admin view (regular user)
        return view('home', compact('categories', 'recentDiscussions'));
    }

    /**
     * Display the specified category with all its discussions.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        // Fetch discussions in this category, sorted by newest first
        $discussions = $category->discussions()->latest()->paginate(10);

        // Return the view with category and its discussions
        return view('categories.show', compact('category', 'discussions'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        // Create the new category
        Category::create([
            'name' => $request->input('name'),
        ]);

        // Redirect with success message
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // Update the category
        $category->update([
            'name' => $request->input('name'),
        ]);

        // Redirect with success message
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        // Delete the category
        $category->delete();

        // Redirect with success message
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
    public function adminHome()
    {
        $categories = Category::withCount('discussions')->get();

        // Prepare data for the chart
        $chartData = [
            'labels' => $categories->pluck('name'),
            'categoryCounts' => $categories->pluck('discussions_count'),
        ];

       
        $users = User::withCount(['discussions', 'posts'])->get();

        // Prepare data for the second chart
        $userChartData = [
            'userLabels' => $users->pluck('name'),
            'discussionCounts' => $users->pluck('discussions_count'),
            'postCounts' => $users->pluck('posts_count'),
        ];

        return view('admin.home.index', compact('chartData', 'userChartData'));
    }
}
