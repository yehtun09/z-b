<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'max:255',
            ],
            'phone_number' => [
                'string',
                'nullable',
                'max:255',
            ],
            'service_type' => [
                'string',
                'nullable',
                'max:255',
            ],
            'address' => [
                'string',
                'required',
            ],
            'township_id' => [
                'integer',
                'required',
            ],
            'ticket_no' => [
                'string',
                'nullable',
                'max:255',
            ],
            'customer_code' => [
                'string',
                'nullable',
                'max:255',
            ],
            'service_plan_id' => [
               'integer',
               'required',
            ],
            'service_type_id' => [
                'integer',
                'required',
            ],
            'site_lat' => [
                'string',
                'nullable',
                'max:255',
            ],
            'site_long' => [
                'string',
                'nullable',
                'max:255',
            ],
            'bandwidth' => [
                'string',
                'nullable',
                'max:255',
            ],
            'register_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'sales_voucher_no' => [
                'string',
                'required',
                'max:255',
            ],
            'contact_person' => [
                'string',
                'nullable',
                'max:255',
            ],
        ];
    }
}
