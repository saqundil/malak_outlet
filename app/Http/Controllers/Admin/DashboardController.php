<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Display the admin dashboard with comprehensive statistics and data
     */
    public function index(): View
    {
        $dashboardData = $this->dashboardService->getDashboardData();
        
        return view('admin.dashboard', $dashboardData);
    }
}
