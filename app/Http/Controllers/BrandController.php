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
        $validated = $request->validate([
            'brand_name' => 'required|string|max:255',
        ]);

        if (Brand::where('brand_name', $request->brand_name)
            ->where('categoryID', $categoryID)
            ->exists()) {
            return response()->json(['error' => 'This brand name already exists in this category.']);
        }

        Brand::create([
            'brand_name' => $validated['brand_name'],
            'categoryID' => $categoryID
        ]);

        return response()->json(['success' => 'Brand created successfully!']);
    }
    
    public function edit($id, $categoryID)
    {
        // Find the brand by its ID
        $brand = Brand::findOrFail($id);
    
        // Pass both the brand and categoryID to the view
        return view('brands.edit', compact('brand', 'categoryID'));
    }
    

    public function update(Request $request, $id, $categoryID)
    {
        $validated = $request->validate([
            'brand_name' => 'required|string|max:255',
        ]);

        if (Brand::where('brand_name', $request->brand_name)
            ->where('categoryID', $categoryID)
            ->where('id', '!=', $id)
            ->exists()) {
            return response()->json(['error' => 'This brand name already exists in this category.']);
        }

        $brand = Brand::findOrFail($id);
        $brand->brand_name = $validated['brand_name'];
        $brand->save();

        return response()->json(['success' => 'Brand updated successfully!']);
    }

    public function destroy($id,$categoryID)
    {
        Brand::where('id',$id)->delete();

        return redirect()->route('brands.index', ['categoryID' => $categoryID])->with('success', 'Brand Deleted Successfully!');
    }

    public function checkBrand(Request $request)
    {
        $exists = Brand::where('brand_name', $request->brand_name)
                    ->where('categoryID', $request->categoryID)
                    ->exists();

        return response()->json(['exists' => $exists]);
    }

}
