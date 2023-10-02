<?php

namespace App\Http\Requests;

use App\Models\Invoice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('invoice_create');
    }

    public function rules()
    {
        return [
            'customer_name_id' => [
                'required',
                'integer',
            ],
            'start_meter' => [
                'nullable',
                'integer',
            ],
            'end_meter' => [
                'nullable',
                'integer',
            ],
            'drop_cable_length' => [
                'nullable',
                'integer',
            ],
            'cable_drum_no' => [
                'nullable',
                'integer',
            ],
            'drop_sleeve_pcs' => [
                'nullable',
                'integer',
            ],
            'core_jc_sleeve_holder_pcs' => [
                'nullable',
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
                'nullable',
                'max:255',
            ],
            'odb_lat' => [
                'nullable',
                'max:255',
            ],
            'odb_long' => [
                'nullable',
                'max:255',
            ],
            'odb_splitter_no' => [
                'nullable',
                'max:255',
            ],
            'odb_splitter_pair_no' => [
                'nullable',
                'max:255',
            ],
            'ont_received_power' => [
                'nullable',
                'max:255',
            ],
            'olt_name' => [
                'nullable',
                'max:255',
            ],
            // 'assign_team' => [//for required
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
