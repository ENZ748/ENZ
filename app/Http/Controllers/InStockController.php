<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InStock;
use App\Models\Employees;
class InStockController extends Controller
{
    public function index()

    {
        $in_stocks = InStock::with(['employee', 'item.category', 'item.brand', 'item.unit'])
        ->where('status', 0)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('Instock.index', compact('in_stocks'));
    }

}
