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
        $count_items = Item::count();
        $returned_items = AssignedItem::where('item_status', 'returned')->count();
        return view('chart', compact('count_items', 'returned_items'));
    }
    
    public function showChart()
{
    $currentYear = Carbon::now()->year;
    $lastUpdated = Carbon::now()->format('M d, Y');
    
    // Get all distinct years that have data in any relevant table
    $itemYears = Item::selectRaw('YEAR(date_acquired) as year')
        ->distinct()
        ->pluck('year');
        
    $employeeYears = Employees::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->pluck('year');
        
    $assignedYears = AssignedItem::selectRaw('YEAR(updated_at) as year')
        ->distinct()
        ->pluck('year');
    
    // Combine all years and ensure uniqueness
    $allYears = $itemYears->merge($employeeYears)
                         ->merge($assignedYears)
                         ->unique()
                         ->sort()
                         ->values();
    
    // Always include current year if not present
    if (!$allYears->contains($currentYear)) {
        $allYears->push($currentYear);
        $allYears = $allYears->sort();
    }
    
    $yearlyData = [];
    foreach ($allYears as $year) {
        $yearlyData[$year] = [
            'equipment' => $this->getEquipmentData($year),
            'users' => $this->getUserData($year),
            'returned' => $this->getReturnedData($year),
            'damaged' => $this->getDamagedData($year)
        ];
    }
    
    // Main counts

    $currentMonthItems = Item::where('quantity', '>', 0)
                       ->whereYear('date_acquired', Carbon::now()->year)
                       ->whereMonth('date_acquired', Carbon::now()->month)
                       ->count();


$count_items = Item::where('quantity', '>', 0)->count();
$count_categories = Category::count();
$count_returned_items = AssignedItem::where('item_status', 'returned')->count();
$count_inStock = Item::where('equipment_status', 0)
                    ->where('quantity', '>', 0)
                    ->count();

// Items calculations
$lastMonthItems = Item::where('quantity', '>', 0)
                     ->whereYear('date_acquired', Carbon::now()->subMonth()->year)
                     ->whereMonth('date_acquired', Carbon::now()->subMonth()->month)
                     ->count();
$itemsChange = $lastMonthItems > 0 ? round((($currentMonthItems - $lastMonthItems) / $lastMonthItems * 100), 1) : 0;

// Categories calculations
$newCategoriesThisMonth = Category::whereYear('created_at', Carbon::now()->year)
                                 ->whereMonth('created_at', Carbon::now()->month)
                                 ->count();

// Returned items calculations
$lastMonthReturns = AssignedItem::where('item_status', 'returned')
                              ->whereYear('updated_at', Carbon::now()->subMonth()->year)
                              ->whereMonth('updated_at', Carbon::now()->subMonth()->month)
                              ->count();
$returnsChange = $lastMonthReturns > 0 ? round((($count_returned_items - $lastMonthReturns) / $lastMonthReturns * 100), 1) : 0;

// Stock calculations
$stockPercentage = $count_items > 0 ? round(($count_inStock / $count_items * 100), 1) : 0;

// For modals


$categoriesWithCount = Category::withCount(['items' => function($query) {
                              $query->where('quantity', '>', 0);
                          }])
                          ->having('items_count', '>', 0)
                          ->orderByDesc('items_count')
                          ->get();

$largestCategory = $categoriesWithCount->first();
$smallestCategory = $categoriesWithCount->last();

$returnedThisMonth = AssignedItem::where('item_status', 'returned')
                               ->whereYear('updated_at', Carbon::now()->year)
                               ->whereMonth('updated_at', Carbon::now()->month)
                               ->count();
$returnRate = $count_items > 0 ? round(($count_returned_items / $count_items * 100), 1) : 0;

$lowStockThreshold = 5;
$lowStockItems = Item::where('equipment_status', 0)
                    ->where('quantity', '>', 0)
                    ->where('quantity', '<=', $lowStockThreshold)
                    ->count();
$outOfStockItems = Item::where('equipment_status', 0)
                     ->where('quantity', 0)
                     ->count();

return view('chart', compact(
    'yearlyData',
    'currentYear',
    'lastUpdated',
    'count_items',
    'count_categories',
    'count_returned_items',
    'count_inStock',
    'lastMonthItems',
    'itemsChange',
    'newCategoriesThisMonth',
    'returnsChange',
    'stockPercentage',
    'currentMonthItems',
    'categoriesWithCount',
    'largestCategory',
    'smallestCategory',
    'returnedThisMonth',
    'returnRate',
    'lowStockItems',
    'outOfStockItems',
    'lowStockThreshold'
));
}
    
    private function getEquipmentData($year)
    {
        $monthlyCounts = Item::whereYear('date_acquired', $year)
            ->selectRaw('MONTH(date_acquired) as month, COUNT(*) as count')
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
            'labels' => $labels,
            'values' => $values
        ];
    }
    
    private function getUserData($year)
    {
        $monthlyCounts = Employees::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
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
            'labels' => $labels,
            'values' => $values
        ];
    }
    
    private function getReturnedData($year)
    {
        $monthlyCounts = AssignedItem::where('item_status', 'returned')
            ->whereYear('updated_at', $year)
            ->selectRaw('MONTH(updated_at) as month, COUNT(*) as count')
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
            'labels' => $labels,
            'values' => $values
        ];
    }
    
    private function getDamagedData($year)
    {
        $monthlyCounts = Item::where('equipment_status', 2)
            ->whereYear('updated_at', $year)
            ->selectRaw('MONTH(updated_at) as month, COUNT(*) as count')
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
            'labels' => $labels,
            'values' => $values
        ];
    }
}