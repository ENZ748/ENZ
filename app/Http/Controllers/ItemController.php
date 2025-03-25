<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
    
        $items = Item::all();
        $categories = Category::all();

        return view('items.index', compact('items', 'categories'));
    }

    // Show the item creation form
    public function create()
    {
        // Fetch all categories
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    // Store the new item
    public function store(Request $request)
    {
        \Log::info($request->all());
        $categoryId = intval($request->category_id);

        // Validate the form data
        $request->validate([
            'category_id'    => 'required|exists:categories,id', 
            'brand_id'       => 'required|exists:brands,id', 
            'unit_id'        => 'required|exists:units,id', 
            'serial_number'  => 'required|unique:items,serial_number', 
            'equipment_status' => 'required|in:0,1,2', 
            'date_purchased' => 'required|date',
            'date_acquired'  => 'required|date',
        ]);

        // Create the new item in the database
        Item::create([
            'categoryID'      => $request->category_id,
            'brandID'         => $request->brand_id,
            'unitID'          => $request->unit_id,
            'serial_number'   => $request->serial_number,
            'equipment_status'=> $request->equipment_status,
            'date_purchased'  => $request->date_purchased,
            'date_acquired'   => $request->date_acquired,
        ]);

        // Redirect back to the form with a success message
        return redirect()->route('items')->with('success', 'Item added successfully!');
    }

    //Update Item
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        
        // Load the initial brand and unit based on the item data
        $brands = Brand::where('categoryID', $item->categoryID)->get();
        $units = Unit::where('brandID', $item->brandID)->get();
    
        return view('items.edit', compact('item', 'categories', 'brands', 'units'));
    }
    

    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'serial_number' => 'required|string|max:255',
            'equipment_status' => 'required|in:0,1,2',
            'date_purchased' => 'required|date',
            'date_acquired' => 'required|date',
        ]);

        // Retrieve the item from the database
        $item = Item::findOrFail($id);

        // Update the item with the validated data
        $item->categoryID = $validated['category_id'];
        $item->brandID = $validated['brand_id'];
        $item->unitID = $validated['unit_id'];
        $item->serial_number = $validated['serial_number'];
        $item->equipment_status = $validated['equipment_status'];
        $item->date_purchased = $validated['date_purchased'];
        $item->date_acquired = $validated['date_acquired'];

        // Save the updated item
        

        // Redirect back to the edit page with a success message
        return redirect()->route('items', $item->id)
            ->with('success', 'Item updated successfully!');
    }
   
    //Delete Item
    public function destroy($id)
    {
        Item::where('id', $id)->delete();

        return redirect()-> route('items')->with('success', 'Item deleted successfully');  
    }



    //Search Category
    public function category(Request $request)
    {
        // Fetch all categories to populate the select dropdown
        $categories = Category::all();

        // Get the selected category id (if any)
        $categoryId = $request->input('category_id');

        // Filter items based on the selected category, if provided
        $items = Item::when($categoryId, function ($query, $categoryId) {
            return $query->where('categoryID', $categoryId);
        })->get();

        // Return the view with categories and filtered items
        return view('items.index', compact('items', 'categories'));
    }

    //Filter add and update
    public function getBrands($categoryId)
    {
        $brands = Brand::where('categoryID', $categoryId)->get();
        return response()->json($brands);
    }

    public function getUnits($brandId)
    {
        $units = Unit::where('brandID', $brandId)->get();
        return response()->json($units);
    }

}
