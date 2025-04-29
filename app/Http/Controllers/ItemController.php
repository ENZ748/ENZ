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
        Item::whereIn('equipment_status', [1, 2])
        ->where('quantity', 0)
        ->delete();

        $items = Item::with(['category', 'brand', 'unit'])
        ->where('quantity', '>', 0)
        ->orderBy('created_at', 'DESC')
        ->paginate(12);

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
    // In your controller (e.g., ItemController.php)
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'serial_number' => 'required',
            'quantity' => 'required|integer|min:1',
            'date_purchased' => 'required|date',
            'date_acquired' => 'required|date',
        ]);

        $existingItem = Item::where('categoryID', $validated['category_id'])
        ->where('brandID', $validated['brand_id'])
        ->where('unitID', $validated['unit_id'])
        ->where('serial_number', $validated['serial_number'])
        ->first();

        if ($existingItem) {
            return response()->json([
                "success" => false,
                "message" => "Validation failed",
                "errors" => [
                    "serial_number" => ["Serial Number already exists!"]
                ]
            ], 422);
        }
        else{
            $item = Item::create([
                'categoryID'      => $validated['category_id'],
                'brandID'         => $validated['brand_id'],
                'unitID'          => $validated['unit_id'],
                'serial_number'   => $request->serial_number,
                'quantity'        => $request->quantity,
                'equipment_status'=> 0,
                'date_purchased'  => $request->date_purchased,
                'date_acquired'   => $request->date_acquired,
            ]);

        }
        return response()->json([
            'success' => true,
            'message' => 'Item added successfully',
            'data' => $item
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Server error: '.$e->getMessage()
        ], 500);
    }
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
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
                'unit_id' => 'required|exists:units,id',
                'serial_number' => 'required|unique:items,serial_number,'.$id,
                'quantity' => 'required|integer',
                'date_purchased' => 'required|date',
                'date_acquired' => 'required|date',
            ]);
    
            $item = Item::findOrFail($id);
            
            // Map the validated data to your model's field names
            $updateData = [
                'categoryID' => $validated['category_id'],
                'brandID' => $validated['brand_id'],
                'unitID' => $validated['unit_id'],
                'serial_number' => $validated['serial_number'],
                'quantity' => $validated['quantity'],
                'date_purchased' => $validated['date_purchased'],
                'date_acquired' => $validated['date_acquired'],
            ];
    
            $item->update($updateData);
    
            return response()->json([
                'success' => true,
                'message' => 'Item updated successfully',
                'data' => $item
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: '.$e->getMessage()
            ], 500);
        }
    }

    
   
    //Delete Item
    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting item: '.$e->getMessage()
            ], 500);
        }
    }
    


    public function search(Request $request)
    {
        Item::whereIn('equipment_status', [1, 2])
        ->where('quantity', 0)
        ->delete();
        
        // Start with a query that eagerly loads related models and orders by latest
        $itemsQuery = Item::with(['category', 'brand', 'unit'])
                        ->where('quantity', '>', 0)
                        ->orderBy('created_at', 'DESC');

        // Initialize a message variable
        $message = '';

        // Apply the search filter based on the "search" term
        if ($request->has('search') && $request->search !== '') {
            $searchTerm = $request->search;
            $itemsQuery->where(function ($query) use ($searchTerm) {
                $query->where('serial_number', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($query) use ($searchTerm) {
                        $query->where('category_name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('brand', function ($query) use ($searchTerm) {
                        $query->where('brand_name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('unit', function ($query) use ($searchTerm) {
                        $query->where('unit_name', 'like', '%' . $searchTerm . '%');
                    });
            });
        } 

        // Filter by equipment status only if it's not empty or null and not '3' (All Status)
        if ($request->filled('equipment_status') && $request->equipment_status !== '3') {
            $itemsQuery->where('equipment_status', $request->equipment_status);
        }

        // Paginate the results (15 items per page by default)
        $items = $itemsQuery->paginate($request->per_page ?? 12);

        // Check if no items were found
        if ($items->isEmpty()) {
            $message = $request->has('search') && $request->search !== '' 
                ? "No items found for the search term: " . $request->search
                : "No items found matching your criteria.";
        }

        // Get all the other necessary data
        $assigned_items = AssignedItem::all();
        $categories = Category::all();

        // Return the view with the necessary data
        return view('items.index', [
            'items' => $items,
            'categories' => $categories,
            'assigned_items' => $assigned_items,
            'message' => $message,
            'search_term' => $request->search ?? '',
            'selected_status' => $request->equipment_status ?? '3'
        ]);
    }

    public function repair(Item $item)
    {
        $itemDamaged = $item; // Optional, or just use $item directly below
    
        $itemStatus = Item::where('categoryID', $item->categoryID)
            ->where('brandID', $item->brandID)
            ->where('unitID', $item->unitID)
            ->where('serial_number', $item->serial_number)
            ->where('equipment_status', 0)
            ->first();
    
        if ($itemStatus) {
            $item->quantity = max(0, $item->quantity - 1);
            $item->save();
    
            $itemStatus->quantity += 1;
            $itemStatus->save();
        } else {
            $item->update(['equipment_status' => 0]);
        }
    
        return redirect()->back()->with('success', 'Item marked as repaired');
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
