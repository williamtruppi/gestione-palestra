<?php

namespace App\Http\Resources;

use App\Models\Booking;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'membershipType' => $this->membership_type,
            'membershipDuration' => $this->membership_duration,
            'membershipStatus' => $this->membership_status,
            'cardCode' => $this->card_code,
            'bookings' => BookingResource::collection($this->whenLoaded('bookings'))
        ];
    }
}
