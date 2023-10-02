<?php

namespace App\Http\Requests;

use App\Models\Invoice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('invoice_edit');
    }

    public function rules()
    {
        return [
            'invoice_code' => [
                'string',
                'required',
            ],
            'customer_name_id' => [
                'required',
                'integer',
            ],
            'products.*' => [
                'integer',
            ],
            'products' => [
                'required',
                'array',
            ],
            'customer_assign' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'start_meter' => [
                'required',
                'integer',
            ],
            'end_meter' => [
                'required',
                'integer',
            ],
            'drop_cable_length' => [
                'required',
                'integer',
            ],
            'cable_drum_no' => [
                'required',
                'integer',
            ],
            'drop_sleeve_pcs' => [
                'required',
                'integer',
            ],
            'core_jc_sleeve_holder_pcs' => [
                'required',
                'integer',
            ],
            'issue_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
                
            ],
            'total_amount' => [
                'integer',
                'nullable',
            ],
            'total_qty' => [
                'integer',
                'nullable',
            ],
            'received_total_amount' => [
                'nullable',
                'integer',
            ],
            'received_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'finished_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'suspend_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'assign_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'odb_no' => [
                'required',
                'max:255',
            ],
            'odb_lat' => [
                'required',
                'max:255',
            ],
            'odb_long' => [
                'required',
                'max:255',
            ],
            'odb_splitter_no' => [
                'required',
                'max:255',
            ],
            'odb_splitter_pair_no' => [
                'required',
                'max:255',
            ],
            'ont_received_power' => [
                'required',
                'max:255',
            ],
            'olt_name' => [
                'required',
                'max:255',
            ],
            // 'assign_team' => [
            //     'required',
            //     'max:255',
            // ],
            'user_id' =>[
                'required',
                'integer',
            ],
            'installation_period' => [
                'nullable',
                'max:255',
            ],
            'resolution' => [
                'nullable',
                'max:255',
            ],
            'cable_tiles_pcs' => [
                'nullable',
                'max:255',
            ],
            'label_tape_rol' => [
                'nullable',
                'max:255',
            ],
            'onu_sticker' => [
                'nullable',
                'max:255',
            ],
            'customer_acceptance_form' => [
                'nullable',
                'max:255',
            ],
        ];
    }
}
