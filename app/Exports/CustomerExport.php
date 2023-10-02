<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $customers = Customer::with(['created_by'])->orderBy('created_at','asc')->get();
        $customers_list= [];
        foreach($customers as $customer){
            array_push($customers_list,[
                'sales_voucher_no'     =>$customer->sales_voucher_no ?? '' ,
                'customer_code' =>$customer->customer_code ?? '',
                'name'      =>$customer->name ?? '' ,
                'contact_person'      =>$customer->contact_person ?? '' ,
                'phone_number'      =>$customer->phone_number ?? '' ,
                'ticket_no'      =>$customer->ticket_no ?? '',
                'service_type'      =>$customer->service_type->service_type ?? '' ,
                'service_plan'  =>$customer->service_plan->service_plan ?? '',
                'register_date'     =>$customer->register_date ?? '' ,
                'bandwidth'     =>$customer->bandwidth ?? '' ,
                'site_lat'      =>$customer->site_lat ?? '' ,
                'site_long'      =>$customer->site_long ?? '' ,
                'township'      =>$customer->township->township ?? '' ,
                'address'      =>$customer->address ?? '' ,
            ]);
        };
        // dd($customers_list);
        return collect($customers_list);
    }
    public function headings(): array
    {
        return [
            trans('cruds.customer.fields.sales_voucher_no'),
            trans('cruds.customer.fields.customer_code'),
            trans('cruds.customer.fields.name'),
            trans('cruds.customer.fields.contact_person'),
            trans('cruds.customer.fields.phone_number'),
            trans('cruds.customer.fields.ticket_no'),
            trans('cruds.customer.fields.service_type'),
            trans('cruds.customer.fields.service_plan'),
            trans('cruds.customer.fields.register_date'),
            trans('cruds.customer.fields.bandwidth'),
            trans('cruds.customer.fields.site_lat'),
            trans('cruds.customer.fields.site_long'),
            trans('cruds.customer.fields.township'),
            trans('cruds.customer.fields.address'),
        ];
    }
}
