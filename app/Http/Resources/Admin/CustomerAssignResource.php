<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerAssignResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'customer_name' => $this->customer_name->name,
            'service_area'  => $this->customerAssign->service_area
        ];
    }
}
