<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\AssignedItem;
use App\Models\ItemHistory;
use App\Models\File;
use App\Models\UploadedFile;
use App\Models\ReturnSignedItem;
use App\Models\ReturnFile;
use App\Models\AssetSignedItem;

class AssignedItemFormController extends Controller
{
    public function index()
    {
        $employees = Employees::whereHas('users', function ($query) {
                $query->whereIn('usertype', ['user', 'admin'])
                    ->where('id', '!=', auth()->id());
            })
            ->orderBy('hire_date', 'desc')
            ->paginate(10);
        
        $files = UploadedFile::with('employee')->get(); // Eager load employee relationship
        $returnfiles = ReturnFile::with('employee')->get(); // Eager load employee relationship

        return view('assigned_item_forms.index', compact('employees', 'files','returnfiles'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $employees = Employees::whereHas('users', function ($query) {
            $query->whereIn('usertype', ['user', 'admin'])
                ->where('id', '!=', auth()->id());
        })
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_number', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        })
            
        ->orderBy('hire_date', 'desc')
        ->paginate(10)
        ->appends(['search' => $search]);

        return view('assigned_item_forms.index', compact('employees', 'search'));
    }

    public function accountability_form($id)
    {
        $employee = Employees::findOrFail($id);

        $assigned_items = AssignedItem::where('employeeID', $employee->id)
        ->where('item_status', 'unreturned')
        ->where('status', 0)
        ->get();

        return view('assigned_item_forms.accountability_form',compact('assigned_items'));
    }

    public function asset_return_form($id)
    {
        $employee = Employees::findOrFail($id);

        $history_items = ItemHistory::where('employeeID', $employee->id)
        ->orderBy('created_at', 'desc')
        ->where('status', 0)
        ->get();

        return view('assigned_item_forms.asset_return',compact('history_items'));
    }

    public function confirm_accountability($id)
    {
        $employee = Employees::findOrFail($id);
        $assigned_items = AssignedItem::where('employeeID', $employee->id)
        ->where('status', 0)
        ->get();

        $signedItem = AssetSignedItem::where('employeeID', $employee->id)->first();

        if ($signedItem) {
            $itemCount = AssetSignedItem::where('employeeID', $employee->id)->count();
            
            if ($itemCount > 1) {
                $signedItem = AssetSignedItem::where('employeeID', $employee->id)
                    ->latest()
                    ->first();
            }
        } 
 
        foreach ($assigned_items as $assigned_item) {
            $assigned_item->status = 1;
            $assigned_item->fileID = $signedItem->id;
            $assigned_item->save();
        }

        return redirect('form');
    }

    public function confirm_History($id)
    {
        $employee = Employees::findOrFail($id);
        $history_items = ItemHistory::where('employeeID', $employee->id)
        ->where('status', 0)
        ->get();

        $returnSignedItem = ReturnSignedItem::where('employeeID', $employee->id)->latest()->first();

        foreach ($history_items as $history_item) {
            $history_item->status = 1;
            $history_item->fileID = $returnSignedItem->id;
            $history_item->save();
        }

        return redirect('form');
    }

}
  