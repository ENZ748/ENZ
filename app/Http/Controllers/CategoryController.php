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
        // Check if unit name already exists
         $existingCategory = Category::where('category_name', $request->category_name)->first();

        if ($existingCategory) {
         // Return with error if the unit name already exists
         return redirect()->back()->withErrors(['category_name' => 'The Category name already exists. Please choose a different name.'])->withInput();
        }

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

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $existingCategory = Category::where('category_name', $request->category_name)->first();

        if ($existingCategory) {
         // Return with error if the unit name already exists
         return redirect()->back()->withErrors(['category_name' => 'The Category name already exists. Please choose a different name.'])->withInput();
        }


        $validated = $request->validate([
            'category_name' => 'required|unique:categorytbl,category_name|max:255',
        ]);

        $category = Category::findOrFail($id);

        $category->category_name =$validated['category_name'];

        $category->save();

        return redirect()->route('categories.index', $category->id)->with('success', 'Category Updated Successfully!');
    }

    public function destroy($id)
    {
        Category::where('id', $id)->delete();

        return redirect()-> route('categories.index')->with('success', 'Item deleted successfully');  
    }

    public function checkCategory(Request $request)
    {
        // Check if the category already exists in the database
        $exists = Category::where('category_name', $request->category_name)->exists();

        return response()->json(['exists' => $exists]);
    }

}
