<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function showChart()
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
        $values = [10, 20, 15, 25, 30]; // Replace with dynamic data if needed

        return view('chart', compact('labels', 'values'));
    }
}
