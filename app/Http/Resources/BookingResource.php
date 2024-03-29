<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'customerId' => $this->customer_id,
            'lessonId' => $this->lesson_id,
            'customerName' => $this->customer_name,
            'courseName' => $this->course_name,
            'startTime' => $this->start_time,
            'endTime' => $this->end_time
        ];
    }
}
