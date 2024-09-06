<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'user_id' => $this->user_id,
        ];
    }
}
