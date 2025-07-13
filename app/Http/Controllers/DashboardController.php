<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Product;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $totalEmployees = User::where('is_active', true)->count();
        $activeProjects = 15; // This would come from a projects table when implemented
        $totalRevenue = 125000; // This would come from sales/revenue calculations
        $pendingTasks = LeaveRequest::where('status', 'pending')->count();
        $monthlyEarnings = 45000; // This would be calculated from current month revenue

        return view('dashboard', compact(
            'totalEmployees',
            'activeProjects',
            'totalRevenue',
            'pendingTasks',
            'monthlyEarnings'
        ));
    }
}
