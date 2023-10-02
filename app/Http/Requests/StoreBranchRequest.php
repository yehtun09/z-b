<?php

namespace App\Http\Requests;

use App\Models\Branch;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBranchRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('branch_create');
    }

    public function rules()
    {
        return [
            'branch' => [
                'string',
                'required',
            ],
            'phone' => [
                'string',
                'required',
            ],
        ];
    }
}
