<?php

namespace App\Http\Repositories;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Support\Carbon;

class UserRepository
{
    public static function getFilteredOrders($user, $status = null, $paymentStatus = null, $dateRange = null)
    {
        $query = Order::query()
            ->where('user_id', $user->id)
            ->when($paymentStatus, function ($q, $paymentStatus) {
                return $q->where('status', $paymentStatus);
            })
            ->when($status, function ($q, $status) {
                return $q->whereHas('orderDetails', function ($q) use ($status) {
                    return $q->where('status', $status);
                });
            })
            ->when($dateRange, function ($q, $dateRange) {
                $startDate = Carbon::parse($dateRange['start_date'])->startOfDay();
                $endDate = Carbon::parse($dateRange['end_date'])->endOfDay();
                return $q->whereBetween('created_at', [$startDate, $endDate]);
            });

        $orders = $query->get();

        return OrderResource::collection($orders);
    }

    // Other methods remain unchanged...
}
