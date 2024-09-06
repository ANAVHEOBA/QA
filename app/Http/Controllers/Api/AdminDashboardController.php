<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function getOverviewAnalytics()
    {
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalRevenue = Order::sum('total_amount');
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        return response()->json([
            'total_orders' => $totalOrders,
            'total_users' => $totalUsers,
            'total_revenue' => $totalRevenue,
            'average_order_value' => $averageOrderValue,
        ]);
    }

    public function getOrderTrends()
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $orderTrends = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->get();

        return response()->json($orderTrends);
    }

    public function getTopSellingProducts()
    {
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(10)
            ->get();

        return response()->json($topProducts);
    }

    public function getUserActivityMetrics()
    {
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $activeUsers = User::whereHas('orders', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        })->count();

        return response()->json([
            'new_users_last_30_days' => $newUsers,
            'active_users_last_30_days' => $activeUsers,
        ]);
    }

    public function getRecentOrders()
    {
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json($recentOrders);
    }

    public function getInventoryStatus()
    {
        $lowStockThreshold = 10; // Define your low stock threshold

        $inventoryStatus = Product::select('id', 'name', 'stock_quantity')
            ->orderBy('stock_quantity', 'asc')
            ->get()
            ->map(function ($product) use ($lowStockThreshold) {
                $product->status = $product->stock_quantity <= $lowStockThreshold ? 'Low Stock' : 'In Stock';
                return $product;
            });

        return response()->json($inventoryStatus);
    }

    public function getDashboardData()
    {
        $overviewAnalytics = $this->getOverviewAnalytics()->original;
        $orderTrends = $this->getOrderTrends()->original;
        $topSellingProducts = $this->getTopSellingProducts()->original;
        $userActivityMetrics = $this->getUserActivityMetrics()->original;
        $recentOrders = $this->getRecentOrders()->original;
        $inventoryStatus = $this->getInventoryStatus()->original;

        return response()->json([
            'overview_analytics' => $overviewAnalytics,
            'order_trends' => $orderTrends,
            'top_selling_products' => $topSellingProducts,
            'user_activity_metrics' => $userActivityMetrics,
            'recent_orders' => $recentOrders,
            'inventory_status' => $inventoryStatus,
        ]);
    }
}