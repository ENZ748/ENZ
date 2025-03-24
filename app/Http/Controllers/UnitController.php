<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Category;
class UnitController extends Controller
{
    public function index()
    {
        return view('units.index');
    }
    // Display the form to create a new category
    public function create()
    {
        return view('units.create'); // Make sure you have a view for the form
    }

    // Store the new category in the database
    public function store(Request $request)
    {
        $category = Category::all();

        // Validate the incoming data
        $request->validate([
            'unit_name' => 'required|unique:unittbl,unit_name|max:255',
        ]);

        // Create a new category and save it to the database
        Unit::create([
            'unit_name' => $request->unit_name,
            'brandID' => 1,
        ]);

        // Redirect to a page, for example the index page
        return redirect()->route('units.index')->with('success', 'unit created successfully!');
    }
}
