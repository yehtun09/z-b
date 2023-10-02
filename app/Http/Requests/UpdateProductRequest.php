<?php

namespace App\Http\Requests;

use App\Models\Product;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_edit');
    }

    public function rules()
    {
       
        return [
            'onu_type' => [
                'required',
                'string',
                'max:255',
            ],
            'onu_model_no' => [
                'required',
                'string',
                'max:255',
            ],
            'ont_serial_no' => [
                'required',
                'string',
                'max:255',
            ],
            'onu' => [
                'required',
                'string',
                'max:255',
            ],

            'product_name' => [
                'string',
                'required',
                'max:255',
            ],
            'price' => [
                'required',
            ],
            'stock_qty' => [
                'required',
                'integer',
            ],
            'stock_qty' => [
                'required',
                'integer',
            ],
            'discount' => [
                'integer',
                'nullable',
            ],
            'description' => [
                'string',
                'nullable'
            ],
            'model_no' => [
                'required',
                'string',
                'max:255',
            ],
            'drum_no' => [
                'nullable',
                'string',
                'max:255',
            ],
            // 'length' => [
            //     'nullable',
            //     'string',
            //     'max:255',
            // ],
            'patch_cord' => [
                'nullable',
                'string',
                'max:255',
            ],
            'drop_sleeve' => [
                'nullable',
                'string',
                'max:255',
            ],
            'sleeve_holder' => [
                'nullable',
                'string',
                'max:255',
            ],

        ];
    }
}
