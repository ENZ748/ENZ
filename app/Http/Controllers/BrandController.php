<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;


class BrandController extends Controller
{
    public function index($categoryID)
    {
        $brands = Brand::where('categoryID', $categoryID)->get();
        return view('brands.index', compact('brands', 'categoryID'));
    }

    // Display the form to create a new category
    public function create($categoryID)
    {
        return view('brands.create', compact('categoryID')); // Make sure you have a view for the form
    }

    // Store the new category in the database
    public function store(Request $request, $categoryID)
    {
        // Validate the incoming data
        $request->validate([
            'brand_name' => 'required|string|max:255',
        ]);
        if (Brand::where('brand_name', $request->brand_name)
        ->where('categoryID', $categoryID)
        ->exists()) {
        return back()->withErrors(['brand_name' => 'This brand name already exists in this category.']);
        }
    
    
        // Create a new brand and save it to the database
        Brand::create([
            'brand_name' => $request->brand_name,
            'categoryID' => $categoryID,
        ]);
    
        // Redirect to the brands index page for that category
        return redirect()->route('brands.index', $categoryID)->with('success', 'Brand created successfully!');
    }
    
}
