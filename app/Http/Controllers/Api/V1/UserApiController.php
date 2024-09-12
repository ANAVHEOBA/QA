<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserApiController extends Controller
{
    public function filteredOrders(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'result' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }

            // Example filtering based on query parameters
            $status = $request->query('status');
            $dateFrom = $request->query('date_from');
            $dateTo = $request->query('date_to');

            $ordersQuery = Order::where('user_id', $user->id);

            if ($status) {
                $ordersQuery->whereHas('orderDetails', function ($query) use ($status) {
                    $query->where('status', $status);
                });
            }

            if ($dateFrom) {
                $ordersQuery->whereDate('created_at', '>=', $dateFrom);
            }

            if ($dateTo) {
                $ordersQuery->whereDate('created_at', '<=', $dateTo);
            }

            $orders = $ordersQuery->where('status', PaymentStatus::Success->value)->get();

            return response()->json([
                'result' => true,
                'message' => 'Filtered orders',
                'data' => OrderResource::collection($orders),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error fetching filtered orders: ' . $e->getMessage());

            return response()->json([
                'result' => false,
                'message' => 'An error occurred while fetching orders',
            ], 500);
        }
    }
}
