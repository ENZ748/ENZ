<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InStock;
use App\Models\Employees;

class SuperAdminInStockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = InStock::with(['employee', 'item.category', 'item.brand', 'item.unit'])
            ->where('status', 0);
            
        if ($search) {
            $query->whereHas('employee', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_number', 'like', "%{$search}%");
            })
            ->orWhereHas('item', function($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('category_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('brand', function($q) use ($search) {
                      $q->where('brand_name', 'like', "%{$search}%");
                  });
            });
        }
        
        $in_stocks = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('Instock.superAdminIndex', compact('in_stocks'));
    }
}