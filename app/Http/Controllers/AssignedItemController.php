<?php

namespace App\Http\Controllers;

use App\Models\AssignedItem;
use App\Models\Employees;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Item;
use App\Models\ItemHistory;

use Illuminate\Http\Request;

class AssignedItemController extends Controller
{
    public function index()
    {
        // Fetch all assigned items
        $assignedItems = AssignedItem::where('item_status', 'unreturned')->get();

        // Return the index view with assigned items
        return view('assigned_items.index', compact('assignedItems'));
    }

    // Method to show form for creating a new AssignedItem
    // Show the form for assigning an item
    public function create()
    {
        // Fetch necessary data, like categories, brands, and units
        
        $categories = Category::all(); // assuming you have a Category model
        $categoriesWithItems = Category::whereHas('items', function ($query) {
            $query->where('equipment_status', 0);
        })->get();

        $items = Item::all();
        $employees = Employees::all(); // assuming you have an Employee model

        return view('assigned_items.create', compact('categories', 'employees','categoriesWithItems'));
    }

    // Store the assigned item
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'employeeID' => 'required|exists:employees,id',
            'unit_id' => 'required|exists:units,id',
            'serial_number' => 'required|exists:items,id', // Ensure this is a valid serial number
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Retrieve the item based on the serial_number (id)
        $item = Item::find($validatedData['serial_number']);
        
        // Check if item exists
        if (!$item) {
            return back()->withErrors(['serial_number' => 'The selected serial number is invalid.']);
        }

        // Create the new assigned item
        AssignedItem::create([
            'employeeID' => $validatedData['employeeID'],
            'itemID' => $item->id,
            'notes' => $validatedData['notes'],
            'assigned_date' => $validatedData['assigned_date'],
        ]);

        $itemStatus = Item::where('id',$item->id)->first();
        
        $itemStatus->equipment_status = 1;
        $itemStatus->save();

        return redirect()->route('assigned_items.index')->with('success', 'Item assigned successfully.');
    }

    // Method to show form for editing an existing AssignedItem
    public function edit($id)
    {
        $assignedItem = AssignedItem::findOrFail($id); // Find the assigned item to edit
        $categories = Category::all(); // Fetch categories
        $employees = Employees::all(); // Fetch employees
        $brands = Brand::all(); // Fetch brands
        $units = Unit::all(); // Fetch units
        $items = Item::all(); // Fetch items

        // Pass the data to the view
        return view('assigned_items.edit', compact('assignedItem', 'categories', 'employees', 'brands', 'units','items'));
    }

    // Method to update an existing AssignedItem
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'employeeID' => 'required|exists:employees,id',
            'unit_id' => 'required|exists:units,id',
            'serial_number' => 'required|exists:items,id', // Ensure this is a valid serial number
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Find the AssignedItem by ID
        $assignedItem = AssignedItem::findOrFail($id);

        $item = Item::find($validatedData['serial_number']);
                
        // Check if item exists
        if (!$item) {
            return back()->withErrors(['serial_number' => 'The selected serial number is invalid.']);
        }

        // Update the AssignedItem with the validated data
        $assignedItem->update([
            'employeeID' => $validatedData['employeeID'],
            'itemID' => $item->id,
            'notes' => $validatedData['notes'],
            'assigned_date' => $validatedData['assigned_date'],
        ]);


        // Redirect or return response
        return redirect()->route('assigned_items.index')->with('success', 'Assigned item updated successfully!');
    }

    public function getBrands($categoryId)
    {
        $brands = Brand::whereHas('items', function ($query) {
            $query->where('equipment_status', 0);
        })->where('categoryID', $categoryId)->get();

        return response()->json($brands);
    }

    public function getUnits($brandId)
    {

        $units = Unit::whereHas('items', function ($query) {
            $query->where('equipment_status', 0);
        })->where('brandID', $brandId)->get();

        return response()->json($units);
    }

    public function getSerials($unitId)
    {
        $serials = Item::where('equipment_status', 0)
        ->where('unitID', $unitId)->get();


        return response()->json($serials);
    }



    public function markAsReturned($id)
    {
        // Find the assigned item by its ID
        $assignedItem = AssignedItem::findOrFail($id);

      
        // Update the item status to "returned"
        $assignedItem->item_status = 'returned';
        $assignedItem->save();

        $itemStatus = Item::where('id',$assignedItem->itemID)->first();
        
        $itemStatus->equipment_status = 0;
        $itemStatus->save();

        ItemHistory::create([
            'employeeID' => $assignedItem->employeeID,
            'itemID' => $assignedItem->itemID,
            'notes' => $assignedItem->notes,
            'assigned_date' => $assignedItem->assigned_date,
        ]);


        // Redirect back with a success message
        return redirect()->route('assigned_items.index')->with('success', 'Item marked as returned.');
    }
}
