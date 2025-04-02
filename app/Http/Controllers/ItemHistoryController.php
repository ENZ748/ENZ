<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemHistory;

class ItemHistoryController extends Controller
{
    public function index()
    {
        $assignedItems = ItemHistory::orderBy('created_at','desc')->get();

        // Return the index view with assigned items
        return view('itemHistory.index', compact('assignedItems'));
    }
}
