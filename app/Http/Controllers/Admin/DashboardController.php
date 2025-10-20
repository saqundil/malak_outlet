<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    /**
     * Display the enhanced dashboard with all tables overview
     */
    public function enhanced(): View
    {
        $dashboardData = $this->dashboardService->getDashboardData();
        
        return view('admin.dashboard_enhanced', $dashboardData);
    }

    /**
     * Display a comprehensive tables overview dashboard
     */
    public function tablesOverview(): View
    {
        $dashboardData = $this->dashboardService->getDashboardData();
        
        return view('admin.dashboard_tables', $dashboardData);
    }

    /**
     * Get real-time stats for dashboard widgets
     */
    public function getStats(): JsonResponse
    {
        $stats = $this->dashboardService->getRealtimeStats();
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Get analytics data for charts
     */
    public function analytics(): JsonResponse
    {
        $data = [
            'salesTrends' => $this->dashboardService->getSalesTrends(),
            'orderStatusDistribution' => $this->dashboardService->getOrderStatusDistribution(),
            'monthlyRevenue' => $this->dashboardService->getMonthlyRevenue(6),
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Generate reports
     */
    public function reports(Request $request): View|JsonResponse
    {
        $period = $request->get('period', 'month');
        
        $data = [
            'period' => $period,
            'stats' => $this->dashboardService->getStatistics(),
            'salesData' => $this->dashboardService->getSalesTrends(),
            'topProducts' => $this->dashboardService->getTopProducts(10),
        ];

        if ($request->ajax()) {
            return response()->json(['success' => true, 'data' => $data]);
        }

        return view('admin.reports', $data);
    }

    /**
     * Get product performance data
     */
    public function productsReport(): JsonResponse
    {
        $data = [
            'topProducts' => $this->dashboardService->getTopProducts(10),
            'lowStockProducts' => $this->dashboardService->getLowStockProducts(5, 20),
            'discountedProducts' => $this->dashboardService->getDiscountedProducts(10),
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get sales report data
     */
    public function salesReport(): JsonResponse
    {
        $data = [
            'dailySales' => $this->dashboardService->getSalesTrends(),
            'monthlyRevenue' => $this->dashboardService->getMonthlyRevenue(12),
            'orderStatusDistribution' => $this->dashboardService->getOrderStatusDistribution(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
