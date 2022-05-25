<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'customer_full_name' => "{$this->customer->first_name} {$this->customer->last_name}",
            'address' => "{$this->address_1} {$this->address_2}",
            'plan_type' => $this->plan->type,
            'plan_name' => $this->plan->name,
            'state' => $this->state,
            'plan_monthly_cost' => $this->plan->monthly_cost,
            'order_id' => $this->order_id
        ];
    }
}
