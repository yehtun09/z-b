<?php

namespace App\Imports;

use App\Helpers\helper;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;


class CustomersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $registerDate = Carbon::createFromFormat('d-m-Y', $row['register_date'])->format('Y-m-d');

        // dd($row);
        return new Customer([
            //
            'ticket_no'  =>  $row['ticket_no'],
            'customer_code'  =>  $row['customer_code'],
            'service_plan'  =>  $row['service_plan'],
            'bandwidth'  =>  $row['bandwidth'],
            'register_date'  => $registerDate,
            'sales_voucher_no'  =>  $row['sales_voucher_no'],
            'name'  =>  $row['customer_name'],
            'contact_person'  =>  $row['contact_person'],
            'phone_number'  =>  $row['phone_number'],
            'address'  =>  $row['address'],
            'township'  =>  $row['township'],
            'service_type'  =>  $row['service_type'],
            'site_lat'  =>  $row['site_latitude'],
            'site_long'  =>  $row['site_longitude'],
            
        ]);
    }
}
