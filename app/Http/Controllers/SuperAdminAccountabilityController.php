<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignedItem;
use App\Models\ItemHistory;
use App\Models\Employees;

class SuperAdminAccountabilityController extends Controller
{
    public function index()
    {
        try {
            // Get authenticated user
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please login to access this page');
            }

            // Find the employee record with additional checks
            $employee = Employees::where('user_id', $user->id)->first();

            if (!$employee) {
                // Create empty collections if no employee record exists
                $assigned_items = collect();
                $history_items = collect();
                
                return view('superAdminAccountability.index', compact('assigned_items', 'history_items'))
                    ->with('warning', 'No employee record found for your account');
            }

            // Get assigned items with proper null checks
            $assigned_items = AssignedItem::with(['item.category', 'item.brand', 'item.unit'])
                ->where('employeeID', $employee->id)
                ->where('item_status', 'unreturned')
                ->orderBy('created_at', 'desc')
                ->get() ?? collect(); // Fallback to empty collection

            // Get item history with proper null checks
            $history_items = ItemHistory::with(['item.category', 'item.brand', 'item.unit'])
                ->where('employeeID', $employee->id)
                ->orderBy('created_at', 'desc')
                ->get() ?? collect(); // Fallback to empty collection

            return view('superAdminAccountability.index', compact('assigned_items', 'history_items'));

        } catch (\Exception $e) {
            // Log the error and show a friendly message
            \Log::error('SuperAdmin Accountability Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading your accountability data');
        }
    }
}