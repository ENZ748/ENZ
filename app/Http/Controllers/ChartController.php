<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Item;
use App\Models\Employees;
use App\Models\AssignedItem;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function index()
    {
        $count_items = Item::all()->count();
        $returned_items = AssignedItem::where('item_status', 'returned');
        return view('chart', compact('items'));
    }
    
    public function showChart()
    {
        $currentYear = Carbon::now()->year;
        $lastUpdated = Carbon::now()->format('M d, Y');
        
        $yearlyData = [];
        
        // Generate data for each year from 2025 to 2030
        for ($year = 2025; $year <= 2030; $year++) {
            // Equipment data for the year
            $equipmentData = $this->getEquipmentData($year);
            
            // User data for the year
            $userData = $this->getUserData($year);
            
            // Returned items data for the year
            $returnedData = $this->getReturnedData($year);
            
            // Damaged items data for the year
            $damagedData = $this->getDamagedData($year);
            
            $yearlyData[$year] = [
                'equipment' => $equipmentData,
                'users' => $userData,
                'returned' => $returnedData,
                'damaged' => $damagedData
            ];
        }
        
        $count_items = Item::all()->count();
        $count_categories = Category::all()->count();
        $count_returned_items = AssignedItem::where('item_status', 'returned')->count();
        $count_inStock = Item::where('equipment_status', 0)->count();

        return view('chart', compact(
            'yearlyData',
            'currentYear',
            'lastUpdated',
            'count_items',
            'count_categories',
            'count_returned_items',
            'count_inStock'
        ));
    }
    
    private function getEquipmentData($year)
    {
        $monthlyCounts = Item::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $values = array_fill(0, 12, 0);
        
        foreach ($monthlyCounts as $month => $count) {
            $values[$month - 1] = $count;
        }

        return [
            'labels' => array_slice($labels, 0, 5),
            'values' => array_slice($values, 0, 5)
        ];
    }
    
    private function getUserData($year)
    {
        $monthlyCounts = Employees::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $values = array_fill(0, 12, 0);
        
        foreach ($monthlyCounts as $month => $count) {
            $values[$month - 1] = $count;
        }

        return [
            'labels' => array_slice($labels, 0, 5),
            'values' => array_slice($values, 0, 5)
        ];
    }
    
    private function getReturnedData($year)
    {
        $monthlyCounts = AssignedItem::selectRaw('MONTH(updated_at) as month, COUNT(*) as count')
            ->where('item_status', 'returned')
            ->whereYear('updated_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $values = array_fill(0, 12, 0);
        
        foreach ($monthlyCounts as $month => $count) {
            $values[$month - 1] = $count;
        }

        return [
            'labels' => array_slice($labels, 0, 5),
            'values' => array_slice($values, 0, 5)
        ];
    }
    
    private function getDamagedData($year)
    {
        $monthlyCounts = Item::selectRaw('MONTH(updated_at) as month, COUNT(*) as count')
            ->where('equipment_status', 2)
            ->whereYear('updated_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $values = array_fill(0, 12, 0);
        
        foreach ($monthlyCounts as $month => $count) {
            $values[$month - 1] = $count;
        }

        return [
            'labels' => array_slice($labels, 0, 5),
            'values' => array_slice($values, 0, 5)
        ];
    }
}