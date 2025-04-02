<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Category;
class UnitController extends Controller
{
    public function index($brandID,$categoryID)
    {
        $units = Unit::where('brandID', $brandID)->get();
        return view('units.index', compact('units','brandID','categoryID'));
    }
    // Display the form to create a new category
    public function create($brandID,$categoryID)
    {
        return view('units.create', compact('brandID','categoryID')); // Make sure you have a view for the form
    }   

    // Store the new category in the database
    public function store(Request $request, $brandID, $categoryID)
    {
        // Check if unit name already exists
        $existingUnit = Unit::where('unit_name', $request->unit_name)->first();

        if ($existingUnit) {
            // Return with error if the unit name already exists
            return redirect()->back()->withErrors(['unit_name' => 'The unit name already exists. Please choose a different name.'])->withInput();
        }

        // Create a new unit and save it to the database
        Unit::create([
            'unit_name' => $request->unit_name,
            'brandID' => $brandID,
            'categoryID' => $categoryID, // Include the categoryID if it's required
        ]);

        // Redirect to the units index with success message
        return redirect()->route('units.index', ['brandID' => $brandID, 'categoryID' => $categoryID])
            ->with('success', 'Unit created successfully!');
    }

    public function edit($id, $brandID, $categoryID)
    {
        $unit = Unit::findOrFail($id);

        return view('units.edit', compact('unit', 'brandID', 'categoryID'));
    }

    public function update(Request $request, $id, $brandID, $categoryID)
    {
        // Check if unit name already exists
        $existingUnit = Unit::where('unit_name', $request->unit_name)->first();

        if ($existingUnit) {
           // Return with error if the unit name already exists
            return redirect()->back()->withErrors(['unit_name' => 'The unit name already exists. Please choose a different name.'])->withInput();
        }

        $unit = Unit::findOrFail($id);
        
        $validated = $request->validate([
            'unit_name' => 'required|unique:unittbl,unit_name|max:255',
        ]);

        $unit->unit_name = $validated['unit_name'];

        $unit->save();

        return redirect()->route('units.index', ['id'=>$unit->id, 'brandID'=>$brandID, 'categoryID' => $categoryID])
        ->with('success', 'Unit Updated Successfully');
    }

    public function destroy($id,$brandID, $categoryID)
    {
        Unit::where('id', $id)->delete();

        return redirect()->route('units.index', [ 'brandID'=>$brandID, 'categoryID' => $categoryID])
        ->with('success', 'Unit Deleted Successfully');
    }

    public function checkUnit(Request $request)
    {
        $exists = Unit::where('unit_name', $request->unit_name)->exists();
        return response()->json(['exists' => $exists]);
    }

}
