<?php

namespace App\Http\Requests;

use App\Models\CustomerAssign;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCustomerAssignRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_assign_edit');
    }

    public function rules()
    {
        return [
            'service_person_id' => [
                'required',
                'integer',
            ],
            'service_area' => [
                'required',
            ],
        ];
    }
}
