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
                'categoryID' => $validated['category_id'],
                'brandID' => $validated['brand_id'],
                'unitID' => $validated['unit_id'],
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
    public function search(Request $request)
{
    // Start with a query that eagerly loads related models
    $itemsQuery = Item::with(['category', 'brand', 'unit']); 

    // Initialize a message variable
    $message = '';

    // Apply the search filter based on the "search" term
    if ($request->has('search') && $request->search !== '') {
        $itemsQuery->where(function ($query) use ($request) {
            $query->where('serial_number', 'like', '%' . $request->search . '%')
                ->orWhereHas('category', function ($query) use ($request) {
                    $query->where('category_name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('brand', function ($query) use ($request) {
                    $query->where('brand_name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('unit', function ($query) use ($request) {
                    $query->where('unit_name', 'like', '%' . $request->search . '%');
                });
        });
    } 

    // Filter by equipment status only if it's not empty or null
    if ($request->has('equipment_status') && $request->equipment_status !== '3') {
        $itemsQuery->where('equipment_status', $request->equipment_status);
    }

    // Get the filtered items
    $items = $itemsQuery->get();

    // Check if no items were found
    if ($items->isEmpty()) {
        // If no items were found and there was a search term, set an appropriate message
        if ($request->has('search') && $request->search !== '') {
            $message = "No items found for the search term: " . $request->search;
        } else {
            $message = "No items found.";
        }
    }

    // Get all the other necessary data
    $assigned_items = AssignedItem::all();
    $categories = Category::all();

    // Return the view with the necessary data
    return view('items.index', compact('items', 'categories', 'assigned_items', 'message'));
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
