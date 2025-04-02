<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Item;
use App\Models\Employees;
use App\Models\AssignedItem;
use Illuminate\Http\Request;

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
        //Equipment
            $count_items = Item::count(); // Count all items

            // Fetch item counts grouped by month
            $monthlyCounts = Item::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();

            // Define month labels
            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            // Prepare dynamic values
            $values = array_fill(0, 12, 0); // Default to 0 for all months
            foreach ($monthlyCounts as $month => $count) {
                $values[$month - 1] = $count; // Adjust index since array is 0-based
            }

            // Trim to required months if needed
            $labels = array_slice($labels, 0, 5);
            $values = array_slice($values, 0, 5);
        //User
            $count_users = Employees::count(); // Get total employee count

            // Fetch employee counts grouped by month and year
            $usermonthlyCounts = Employees::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();
            
            // Define month labels
            $userLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            // Prepare dynamic values
            $userValues = array_fill(0, 12, 0); // Default to 0 for all months
            foreach ($usermonthlyCounts as $month => $count) {
                $userValues[$month - 1] = $count; // Adjust index since array is 0-based
            }
            
            // Trim to required months if needed
            $userLabels = array_slice($userLabels, 0, 5);
            $userValues = array_slice($userValues, 0, 5);

        //Returned Items
            $count_returned_items = AssignedItem::where('item_status','returned')->count();
            // Fetch employee counts grouped by month and year
            $returnedItemsmonthlyCounts = AssignedItem::selectRaw('YEAR(updated_at) as year, MONTH(updated_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

            // Define month labels
            $returnedItemsLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            // Prepare dynamic values
            $returnedValues = array_fill(0, 12, 0); // Default to 0 for all months
            foreach ($returnedItemsmonthlyCounts as $month => $count) {
            $returnedValues[$month - 1] = $count; // Adjust index since array is 0-based
            }

            // Trim to required months if needed
            $returnedItemsLabels = array_slice($returnedItemsLabels, 0, 5);
            $returnedValues = array_slice($returnedValues, 0, 5);

        $count_items = Item::all()->count();
        $count_categories = Category::all()->count();
        $count_returned_items = AssignedItem::where('item_status', 'returned')->count();
        $count_inStock = Item::where('equipment_status', 0)->count();

        return view('chart', compact('labels', 'values','userLabels', 'userValues','returnedItemsLabels','returnedValues', 'count_items','count_categories','count_returned_items','count_inStock'));
    }
}
