<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'price' => $this->price, // Assuming price is still relevant
            'quantity' => $this->quantity, // Assuming quantity is still relevant
            'user_id' => $this->user_id, // Assuming user_id is still relevant
            'code' => $this->code, // Additional attribute from the second version
            'order_details' => OrderDetailResource::collection($this->recievedOrderDetails), // Nested resource
        ];
    }
}

