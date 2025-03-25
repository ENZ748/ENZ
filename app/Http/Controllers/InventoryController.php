<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipments;

class InventoryController extends Controller
{
    public function index()
    {
        $equipments = Equipments::orderBy('date_acquired', 'desc')->get();
        return view('inventory.index',compact('equipments'));
    }

    public function create()
    {
          return view('inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_name' => 'required|string|max:255',
            'serial_number'=>  'required|string|max:255',
            'equipment_details' => 'required|string|max:255',
            'date_purchased' => 'required|date',
            'date_acquired' => 'required|date',
        ]);
        Equipments::create([
            'equipment_name' => $request->equipment_name,
            'serial_number' => $request->serial_number,
            'equipment_details' => $request->equipment_details,
            'date_purchased' => $request->date_purchased,
            'date_acquired' => $request->date_acquired,

        ]);

        return redirect()-> route('inventory')->with('success', 'Equipment added  successfully');

    }
    // Update
    public function edit($id)
    {
         $equipment = Equipments::findOrFail($id);

          return view('inventory.edit', compact('equipment'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'equipment_name' => 'required|string|max:255',
            'serial_number'=>  'required|string|max:255',
            'equipment_details' => 'required|string|max:255',
            'date_purchased' => 'required|date',
            'date_acquired' => 'required|date',
        ]);

        $equipment = Equipments::findOrFail($id);
        $equipment->update([
            'equipment_name' => $request->equipment_name,
            'serial_number' => $request->serial_number,
            'equipment_details' => $request->equipment_details,
            'date_purchased' => $request->date_purchased,
            'date_acquired' => $request->date_acquired,

        ]);

        return redirect()-> route('inventory')->with('success', 'Equipment Updated successfully');  

    }


    public function destroy($id)
    {
        Equipments::where('id', $id)->delete();

        return redirect()-> route('inventory')->with('success', 'Equipment deleted successfully');  
    }


}
