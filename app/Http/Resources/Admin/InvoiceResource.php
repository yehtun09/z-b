<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'invoice_id' => $this->id,
            'invoice_code' => $this->invoice_code,
            'service_area' => $this->customerAssign->service_area,
            'customer_assign' => [
                'name' => $this->customer_name->name,
                'phone' => $this->customer_name->phone_number,
                'address' => $this->customer_name->address
            ]
        ];
    }
}
