<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\AssignedItem;
use App\Models\Employees;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Item;
use App\Models\ItemHistory;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\InStock;

use Illuminate\Http\Request;

class AssignedItemController extends Controller
{
    // In your controller method
public function index(Request $request)
{
    $query = AssignedItem::with(['employee', 'item.category', 'item.brand', 'item.unit'])
                ->where('item_status','unreturned')->latest();

    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('employee', function($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('employee_number', 'like', "%$search%");
            })
            ->orWhereHas('item', function($q) use ($search) {
                $q->where('serial_number', 'like', "%$search%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('category_name', 'like', "%$search%");
                  })
                  ->orWhereHas('brand', function($q) use ($search) {
                      $q->where('brand_name', 'like', "%$search%");
                  });
            })
            ->orWhere('assigned_by', 'like', "%$search%"); // Add this line

        });
    }

    $assignedItems = $query->paginate(15);

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


        // Get the current user ID
        $user_id = Auth::user()->id;

        // Find the employee associated with the current user
        $employee = Employees::where('user_id', $user_id)->first();

        // Create the new assigned item
        AssignedItem::create([
            'employeeID' => $validatedData['employeeID'],
            'itemID' => $item->id,
            'notes' => $validatedData['notes'],
            'assigned_date' => $validatedData['assigned_date'],
            'assigned_by' => $employee->employee_number,
        ]);

        $itemStatus = Item::where('id',$item->id)->first();
        
        $itemStatus->quantity = $itemStatus->quantity - 1;
        if($itemStatus->quantity == 0)
        {
            $itemStatus->equipment_status = 1;  
        }
        $itemStatus->save();

        $assignedItem = Employees::where('id',$validatedData['employeeID'])->first();

        $user = Auth::user(); 
        
        $userId = $user->id;
        
        
        ActivityLog::create([
            'user_id' => $userId,
            'activity_logs' => 'Assigned '. $item->serial_number. ' Item to ' . $assignedItem->employee_number,
        ]);

        return redirect()->route('assigned_items.index')->with('success', 'Item assigned successfully.');
    }

    // Method to show form for editing an existing AssignedItem
    public function edit($id)
    {
        $assignedItem = AssignedItem::findOrFail($id); // Find the assigned item to edit
        $categories = Category::whereHas('items', function ($query) {
            $query->where('equipment_status', 0);
        })->get();
        
        $employees = Employees::all(); // Fetch employees
        $items = Item::where('id', $assignedItem->itemID)->get(); // Fetch items

        // Load the initial brand and unit based on the item data
        $brands = Brand::has('items')->where('categoryID', $assignedItem->item->categoryID)->get();
        $units = Unit::has('items')->where('brandID', $assignedItem->item->brandID)->get();


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

        $assignedItem = Employees::where('id',$validatedData['employeeID'])->first();

        $user = Auth::user(); 
      
        $userId = $user->id;  
        
        ActivityLog::create([
            'user_id' => $userId,
            'activity_logs' => 'Update assigned item '. $item->serial_number. ' Item to ' . $assignedItem->employee_number,
        ]);


        // Redirect or return response
        return redirect()->route('assigned_items.index')->with('success', 'Assigned item updated successfully!');
    }

    public function getBrands($categoryId)
    {
        $brands = Brand::whereHas('items', function ($query) {
            $query->where('equipment_status', 0)
            ->where('quantity', '>', 0);  

        })->where('categoryID', $categoryId)->get();

        return response()->json($brands);
    }

    public function getUnits($brandId)
    {

        $units = Unit::whereHas('items', function ($query) {
            $query->where('equipment_status', 0)
                  ->where('quantity', '>', 0);  
        })->where('brandID', $brandId)->get();

        return response()->json($units);
    }

    public function getSerials($unitId)
    {
        $serials = Item::where('equipment_status', 0)
        ->where('quantity', '>', 0)  
        ->where('unitID', $unitId)->get();


        return response()->json($serials);
    }

    public function itemStatus($id)
    {
        $assignedItem = AssignedItem::findOrFail($id); // Find the assigned item to edit

        return view('assigned_items.itemStatus', compact('assignedItem'));
    }

    public function markAsReturned($id)
    {

        // Get the current user ID
        $user_id = Auth::user()->id;

        // Find the employee associated with the current user
        $employee = Employees::where('user_id', $user_id)->first();

        
        // Find the assigned item by its ID
        $assignedItem = AssignedItem::findOrFail($id);

      
        // Update the item status to "returned"
        $assignedItem->item_status = 'returned';
        $assignedItem->save();

        $itemStatus = Item::where('id',$assignedItem->itemID)->first();
        
        $itemStatus->equipment_status = 0;
        $itemStatus->quantity = $itemStatus->quantity + 1;

        $itemStatus->save();

        ItemHistory::create([
            'employeeID' => $assignedItem->employeeID,
            'itemID' => $assignedItem->itemID,
            'notes' => $assignedItem->notes,
            'assigned_date' => $assignedItem->assigned_date,
            'assigned_by' => $assignedItem->assigned_by,
            'returned_to' => $employee->employee_number,
        ]);

        $user = Auth::user(); 
      
        $userId = $user->id;  
        
        ActivityLog::create([
            'user_id' => $userId,
            'activity_logs' => 'Confirmed Item',
        ]);
        InStock::create([
            'employeeID' => $employee->id,
            'itemID' => $assignedItem->itemID,

        ]);


        // Redirect back with a success message
        return redirect()->route('assigned_items.index')->with('success', 'Item marked as returned.');
    }

    public function markAsDamaged($id)
    {       
        // Get the current user ID
        $user_id = Auth::user()->id;

        // Find the employee associated with the current user
        $employee = Employees::where('user_id', $user_id)->first();

        // Find the assigned item by its ID
        $assignedItem = AssignedItem::findOrFail($id);

      
        // Update the item status to "returned"
        $assignedItem->item_status = 'returned';
        $assignedItem->save();

        $itemStatus = Item::where('id',$assignedItem->itemID)->first();
        
        $itemStatus->equipment_status = 2;
        $itemStatus->save();

        ItemHistory::create([
            'employeeID' => $assignedItem->employeeID,
            'itemID' => $assignedItem->itemID,
            'notes' => $assignedItem->notes,
            'assigned_date' => $assignedItem->assigned_date,
            'assigned_by' => $assignedItem->assigned_by,
            'returned_to' => $employee->employee_number,

        ]);

        $user = Auth::user(); 
      
        $userId = $user->id;  
        
        ActivityLog::create([
            'user_id' => $userId,
            'activity_logs' => 'Confirmed Item',
        ]);

        InStock::create([
            'employeeID' => $employee->id,
            'itemID' => $assignedItem->itemID,

        ]);


        // Redirect back with a success message
        return redirect()->route('assigned_items.index')->with('success', 'Item marked as returned.');
    }
}
