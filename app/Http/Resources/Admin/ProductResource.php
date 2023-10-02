<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->product_name,
            'qty' => $this->pivot->qty,
            'unit_price' => $this->sales_price,
            'unit_total' => $this->pivot->total
        ];
    }
}
