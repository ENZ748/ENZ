<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
    // Display the form to create a new category
    public function create()
    {
        return view('categories.create'); // Make sure you have a view for the form
    }
    
    // Store the new category in the database
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'category_name' => 'required|unique:categorytbl,category_name|max:255',
        ]);

        // Create a new category and save it to the database
        Category::create([
            'category_name' => $request->category_name,
        ]);

        // Redirect to a page, for example the index page
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }
}
