<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Item;
use App\Models\Employees;

use App\Models\AssignedItem;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
    
        $items = Item::orderBy('created_at','desc')->get();
        $assigned_items = AssignedItem::all();

        $categories = Category::all();

        return view('items.index', compact('items', 'categories','assigned_items'));
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
            'date_purchased' => 'required|date',
            'date_acquired'  => 'required|date',
        ]);

        // Create the new item in the database
        Item::create([
            'categoryID'      => $request->category_id,
            'brandID'         => $request->brand_id,
            'unitID'          => $request->unit_id,
            'serial_number'   => $request->serial_number,
            'equipment_status'=> 0,
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
        try {
            // Validate the incoming data
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
                'unit_id' => 'required|exists:units,id',
                'serial_number' => 'required|string|max:255',
                'date_purchased' => 'required|date',
                'date_acquired' => 'required|date',
            ]);
    
            // Retrieve the item from the database
            $item = Item::findOrFail($id);
    
            // Update the item using mass assignment
            $item->update([
                'category_id' => $validated['category_id'],
                'brand_id' => $validated['brand_id'],
                'unit_id' => $validated['unit_id'],
                'serial_number' => $validated['serial_number'],
                'date_purchased' => $validated['date_purchased'],
                'date_acquired' => $validated['date_acquired'],
            ]);
    
            // Redirect back with success message
            return redirect()->route('items')->with('success', 'Item updated successfully!');
        } catch (ModelNotFoundException $e) {
            // Catch the exception if the item doesn't exist
            return redirect()->route('items')->with('error', 'Item not found.');
        } catch (\Exception $e) {
            // Catch any other exceptions
            return redirect()->route('items')->with('error', 'An error occurred: ' . $e->getMessage());
        }
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

    public function getSerials($unitId)
    {
        $serials = Item::where('unitID', $unitId)->get();
        return response()->json($serials);
    }

}
