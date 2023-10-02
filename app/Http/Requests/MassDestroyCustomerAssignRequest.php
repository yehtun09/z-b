<?php

namespace App\Http\Requests;

use App\Models\CustomerAssign;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCustomerAssignRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('customer_assign_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:customer_assigns,id',
        ];
    }
}
