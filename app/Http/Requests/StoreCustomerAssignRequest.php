<?php

namespace App\Http\Requests;

use App\Models\CustomerAssign;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCustomerAssignRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_assign_create');
    }

    public function rules()
    {
        return [
            'service_person_id' => [
                'required',
                'integer',
            ],
            'township' => [
                'required',
            ],
            'address' => [
                'required',
            ],
            // 'service_area' => [
            //     'required',
            // ],
        ];
    }
}
