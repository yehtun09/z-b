<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        // dd($request);
        return [
            // 'id' => $this->id,
            'ticket_no'=>$this->ticket_no,
            'customer_code' => $this->customer_code,
            'service_plan'=>$this->service_plan,
            'bandwidth'=>$this->bandwidth,
            'register_date'=>$this->register_date,
            'sales_voucher_no' => $this->sales_voucher_no,
            'name' => $this->name,
            'contact_person'=>$this->contact_person,
            'phone_number'=>$this->phone_number,
            'service_type'=>$this->service_type,
            'address'=>$this->address,
            'township'=>$this->township,
            'site_lat'=>$this->site_lat,
            'site_long'=>$this->site_long,
        ];
    }
}
