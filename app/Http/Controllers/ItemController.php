<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
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
        // Validate the form data
        $request->validate([
            'category_id'    => 'required|exists:categories,id', // Ensure category is valid
            'brand_id'       => 'required|exists:brands,id', // Ensure brand is valid
            'unit_id'        => 'required|exists:units,id', // Ensure unit is valid
            'serial_number'  => 'required|unique:items,serial_number', // Ensure serial number is unique
            'equipment_status' => 'required|in:0,1,2', // Ensure valid equipment status
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
        return redirect()->route('items.create')->with('success', 'Item added successfully!');
    }
}
