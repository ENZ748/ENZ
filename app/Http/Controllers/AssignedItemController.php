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
use App\Models\InUse;
use App\Models\DamagedItem;

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
                ->orWhere('assigned_by', 'like', "%$search%");
            });
        }
    
        $assignedItems = $query->paginate(15);
        
        // Get all necessary data for modals
        $employees = Employees::all();
        $categories = Category::all();
        $categoriesWithItems = Category::whereHas('items', function ($query) {
            $query->where('equipment_status', 0);
        })->get();
        $brands = Brand::all();
        $units = Unit::all();
        $items = Item::all();
    
        return view('assigned_items.index', compact(
            'assignedItems',
            'employees',
            'categories',
            'categoriesWithItems',
            'brands',
            'units',
            'items'
        ));
    }
    
    // Method to show form for creating a new AssignedItem
    public function create()
    {
        $categories = Category::all();
        $categoriesWithItems = Category::whereHas('items', function ($query) {
            $query->where('equipment_status', 0);
        })->get();
        $items = Item::all();
        $employees = Employees::all();
    
        return view('assigned_items.create', compact('categories', 'employees','categoriesWithItems'));
    }
    
    // Store the assigned item
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employeeID' => 'required|exists:employees,id',
            'unit_id' => 'required|exists:units,id',
            'serial_number' => 'required|exists:items,id',
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);
    
        $item = Item::find($validatedData['serial_number']);
        
        if (!$item) {
            return back()->withErrors(['serial_number' => 'The selected serial number is invalid.']);
        }
    
        $user_id = Auth::user()->id;
        $employee = Employees::where('user_id', $user_id)->first();
    
        $newItem = Item::create([
            'categoryID'      => $item->categoryID,
            'brandID'         => $item->brandID,
            'unitID'          => $item->unitID,
            'serial_number'   => $item->serial_number,
            'quantity'        => 1,
            'equipment_status'=> 1,
            'date_purchased'  => $item->date_purchased,
            'date_acquired'   => $item->date_acquired,
        ]);
        
        AssignedItem::create([
            'employeeID'     => $validatedData['employeeID'],
            'itemID'         => $newItem->id,
            'notes'          => $validatedData['notes'],
            'assigned_date'  => $validatedData['assigned_date'],
            'assigned_by'    => $employee->employee_number,
        ]);
    
        $itemStatus = Item::where('id',$item->id)->first();
        $itemStatus->quantity = $itemStatus->quantity - 1;
        $itemStatus->save();
    
        $accountabilityItem = InStock::where('itemID', $item->id)->first();
        if ($accountabilityItem) {
            $accountabilityItem->status = 1;
            $accountabilityItem->save();
        }
    
        $assignedItem = Employees::where('id',$validatedData['employeeID'])->first();
        $user = Auth::user(); 
        $userId = $user->id;
        
        ActivityLog::create([
            'user_id' => $userId,
            'activity_logs' => 'Assigned '. $item->serial_number. ' Item to ' . $assignedItem->employee_number,
        ]);
    
        InUse::create([
            'itemID' => $item->id,
            'employeeID'=>$validatedData['employeeID']
        ]);
    
        return redirect()->route('assigned_items.index')->with('success', 'Item assigned successfully.');
    }
    
    // Method to show form for editing an existing AssignedItem
    public function edit($id)
    {
        $assignedItem = AssignedItem::findOrFail($id);
        $categories = Category::whereHas('items', function ($query) {
            $query->where('equipment_status', 0);
        })->get();
        
        $employees = Employees::all();
        $items = Item::where('id', $assignedItem->itemID)->get();
    
        $brands = Brand::has('items')->where('categoryID', $assignedItem->item->categoryID)->get();
        $units = Unit::has('items')->where('brandID', $assignedItem->item->brandID)->get();
    
        return view('assigned_items.edit', compact('assignedItem', 'categories', 'employees', 'brands', 'units','items'));
    }
    
    // Method to update an existing AssignedItem
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'employeeID' => 'required|exists:employees,id',
            'unit_id' => 'required|exists:units,id',
            'serial_number' => 'required|exists:items,id',
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);
    
        $assignedItem = AssignedItem::findOrFail($id);
        $item = Item::find($validatedData['serial_number']);
                
        if (!$item) {
            return back()->withErrors(['serial_number' => 'The selected serial number is invalid.']);
        }
    
        $assignedItem->update([
            'employeeID' => $validatedData['employeeID'],
            'itemID' => $item->id,
            'notes' => $validatedData['notes'],
            'assigned_date' => $validatedData['assigned_date'],
        ]);
    
        $assignedEmployee = Employees::where('id',$validatedData['employeeID'])->first();
        $user = Auth::user(); 
        $userId = $user->id;  
        
        ActivityLog::create([
            'user_id' => $userId,
            'activity_logs' => 'Update assigned item '. $item->serial_number. ' Item to ' . $assignedEmployee->employee_number,
        ]);
    
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

 
        $itemsInUse = Item::where('id',$assignedItem->itemID)
        ->first();

        $itemsInUse->quantity = max(0, $itemsInUse->quantity - 1);
        $itemsInUse->save();

        

       // Find an available item with matching specifications
        $itemStatus = Item::where('categoryID', $itemsInUse->categoryID)
        ->where('brandID', $itemsInUse->brandID)
        ->where('unitID', $itemsInUse->unitID)
        ->where('serial_number', $itemsInUse->serial_number)
        ->where('equipment_status', 0)
        ->first();

        // Check if item was found before updating
        if ($itemStatus) {
            $itemStatus->quantity += 1;  // More concise increment syntax
            $itemStatus->save();
        } else {
            // Handle case where no matching available item was found
            // You might want to log this or throw an exception
            Log::warning('No available item found for incrementing quantity', [
                'categoryID' => $itemsInUse->categoryID,
                'brandID' => $itemsInUse->brandID,
                'unitID' => $itemsInUse->unitID,
                'serial_number' => $itemsInUse->serial_number
            ]);
        }

        
        
        
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
        $inStock = InStock::where('itemID', $assignedItem->itemID)
        ->where('employeeID', $employee->id)
        ->where('status', 0)->first();
        
        //In Stock(Accountability for available items)
        if ($inStock) {
            // Update quantity if exists
            $inStock->quantity += 1;
            $inStock->save();
        } else {
            InStock::create([
                'employeeID' => $employee->id,
                'itemID' => $assignedItem->itemID,
                 
            ]);
        }
        

        
               
        // Update the item status to "returned"
        $assignedItem->item_status = 'returned';
        $assignedItem->save();
         
        
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

        $items =  Item::where('id',$assignedItem->itemID)->first();


        $itemsInUse = Item::where('id',$assignedItem->itemID)
        ->where('equipment_status', 1)
        ->first();

        if($itemsInUse)
        {
            $itemsInUse->quantity = max(0, $itemsInUse->quantity - 1);
            $itemsInUse->save();
        }



        $itemsDamaged = Item::where('id',$assignedItem->itemID)
        ->where('equipment_status', 2)
        ->first();
        if($itemsDamaged)
        {
            $itemsDamaged->quantity += 1;
            $itemsDamaged->save();
        }else{

            Item::create([
                'categoryID'      => $items->categoryID,
                'brandID'         => $items->brandID,
                'unitID'          => $items->unitID,
                'serial_number'   => $items->serial_number,
                'quantity'        => 1,
                'equipment_status'=> 2,
                'date_purchased'  => $items->date_purchased,
                'date_acquired'   => $items->date_acquired,
            ]);

        }
        

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

        // Update the item status to "returned"
        $assignedItem->item_status = 'returned';
        $assignedItem->save();
        

        // Redirect back with a success message
        return redirect()->route('assigned_items.index')->with('success', 'Item marked as returned.');
    }
}
