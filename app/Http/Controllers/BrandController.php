<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;


class BrandController extends Controller
{
    public function index()
    {
        return view('brands.index');
    }
    // Display the form to create a new category
    public function create()
    {
        return view('brands.create'); // Make sure you have a view for the form
    }

    // Store the new category in the database
    public function store(Request $request)
    {
        $category = Category::all();

        // Validate the incoming data
        $request->validate([
            'brand_name' => 'required|unique:brandtbl,brand_name|max:255',
        ]);

        // Create a new category and save it to the database
        Brand::create([
            'brand_name' => $request->brand_name,
            'categoryID' => 1,
        ]);

        // Redirect to a page, for example the index page
        return redirect()->route('brands.index')->with('success', 'Brand created successfully!');
    }
}
