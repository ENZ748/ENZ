<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Item;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index()
    {
        $count_items = Item::all()->count();

        return view('chart', compact('items'));
    }
    public function showChart()
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
        $values = [10, 20, 15, 25, 30]; // Replace with dynamic data if needed


        $count_items = Item::all()->count();
        $count_categories = Category::all()->count();

        return view('chart', compact('labels', 'values', 'count_items','count_categories'));
    }
}
