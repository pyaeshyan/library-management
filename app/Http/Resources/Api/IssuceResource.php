<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class IssuceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'book' => $this->book->title,
            'category' => $this->category->title,
            'to_return_date' => $this->to_return_date,
            'returned_date' => $this->returned_date,
            'overdue_days' => $this->overdue_days,
            'status' => $this->status,
        ];
    }
}
