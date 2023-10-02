<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceDetailResource extends JsonResource
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
            'sub_total' => $this->sub_total,
            'service_fee' => $this->products[0]->pivot->service_fees,
            'discount' => $this->products[0]->pivot->discount,
            'total' => $this->total,
            'products' => ProductResource::collection($this->products)
        ];
    }
}
