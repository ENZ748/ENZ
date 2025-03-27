<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemHistory;

class ItemHistoryController extends Controller
{
    public function index()
    {
        $assignedItems = ItemHistory::all();

        // Return the index view with assigned items
        return view('itemHistory.index', compact('assignedItems'));
    }
}
