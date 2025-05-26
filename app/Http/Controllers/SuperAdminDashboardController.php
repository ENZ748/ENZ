<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // Get all admins
        $admins = Employees::whereHas('users', function ($query) {
            $query->where('usertype', 'admin');
        })->get();

        // Fetch employee counts grouped by month and year
        $usermonthlyCounts = Employees::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Define month labels (for all months)
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        // Prepare dynamic values (initialize all to 0)
        $values = array_fill(0, 12, 0); // Default to 0 for all months
        
        // Fill in the counts for the months that have data
        foreach ($usermonthlyCounts as $month => $count) {
            $values[(int)$month - 1] = $count;
        }
        
        // Trim to required months if needed (this currently slices to the first 5 months)
        $labels = array_slice($labels, 0, 5);
        $values = array_slice($values, 0, 5);

        //Total Admin
        $count_admin = Employees::whereHas('users', function ($query) {
            $query->where('usertype', 'admin');
        })->count();
        return view('superAdminDashboard.index', compact('admins','count_admin', 'labels', 'values'));
    }
}
