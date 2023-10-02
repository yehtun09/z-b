<?php

namespace App\Exports;

use App\Http\Resources\Admin\CustomerResource;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCustomer implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // dd(Customer::all());
        // return Customer::all();
        return CustomerResource::collection(Customer::all());
    }

    public function headings(): array
    {
        return [
            trans('cruds.customer.fields.ticket_no'),
            trans('cruds.customer.fields.customer_code'),
            trans('cruds.customer.fields.service_plan'),
            trans('cruds.customer.fields.bandwidth'),
            trans('cruds.customer.fields.register_date'),
            trans('cruds.customer.fields.sales_voucher_no'),
            trans('cruds.customer.fields.name'),
            trans('cruds.customer.fields.contact_person'),
            trans('cruds.customer.fields.phone_number'),
            trans('cruds.customer.fields.service_type'),
            trans('cruds.customer.fields.address'),
            trans('cruds.customer.fields.township'),
            trans('cruds.customer.fields.site_lat'),
            trans('cruds.customer.fields.site_long'),
        ];
    }
}
