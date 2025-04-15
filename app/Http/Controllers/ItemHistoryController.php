<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemHistory;

class ItemHistoryController extends Controller
{
    public function index()
    {
        $assignedItems = ItemHistory::orderBy('created_at','desc')
        ->paginate(10);
        
        // Return the index view with assigned items
        return view('itemHistory.index', compact('assignedItems'));
    }

    public function history(Request $request)
    {
        $search = $request->input('search');

        $assignedItems = ItemHistory::with(['employee', 'item.category', 'item.brand', 'item.unit'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    // Search by employee name
                    $q->whereHas('employee', function ($employeeQuery) use ($search) {
                        $employeeQuery->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('employee_number', 'like', '%' . $search . '%');
                    })
                    // Search by item details
                    ->orWhereHas('item', function ($itemQuery) use ($search) {
                        $itemQuery->where('serial_number', 'like', '%' . $search . '%')
                            ->orWhereHas('category', function ($categoryQuery) use ($search) {
                                $categoryQuery->where('category_name', 'like', '%' . $search . '%');
                            })
                            ->orWhereHas('brand', function ($brandQuery) use ($search) {
                                $brandQuery->where('brand_name', 'like', '%' . $search . '%');
                            });
                    })
                    // Search by assignment details
                    ->orWhere('assigned_by', 'like', '%' . $search . '%')
                    ->orWhere('returned_to', 'like', '%' . $search . '%')
                    ->orWhere('notes', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('assigned_date', 'desc')
            ->paginate(15);

        return view('itemHistory.index', compact('assignedItems'));
    }
}
