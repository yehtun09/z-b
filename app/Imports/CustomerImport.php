<?php

namespace App\Imports;
use App\Models\ServicePlan;
use App\Models\ServiceType;
use App\Models\Township;
use Carbon\Carbon;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements WithHeadingRow, ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $service_type = ServiceType::select('id')
        ->where('service_type', 'like', '%' . $row['service_type'] . '%')
        ->first();

        $service_plan = ServicePlan::select('id')
        ->where('service_plan', 'like', '%' . $row['service_plan'] . '%')
        ->first();


        $township = Township::select('id')
        ->where('township', 'like', '%' . $row['township'] . '%')
        ->first();

         $customer = Customer::create([
            'sales_voucher_no' => $row['sale_voucher_no'] ?? '',
            'customer_code' => $row['customer_code'] ?? '',
            'name' => $row['customer_name'] ?? '',
            'contact_person' => $row['contact_person'] ?? '',
            'phone_number' => $row['phone_number'] ?? '',
            'ticket_no' => $row['ticket_no'] ?? '',
            'service_type_id' => $service_type ? $service_type->id : null,
            'service_plan_id' => $service_plan ? $service_plan->id : null,
            'register_date' => $row['register_date'] ? $this->getDate($row['register_date']) : null,
            'bandwidth' => $row['bandwidth'] ?? '',
            'site_lat' => $row['site_latitude'] ?? '',
            'site_long' => $row['site_longitude'] ?? '',
            'township_id' => $township ? $township->id : null,
            'address' => $row['address'] ?? '',
        ]);

        $customer->location()->create(['area_site_lat'=> null ,'area_site_long' => null]);

        return $customer;

    }

    protected function getDate($date){
        if($date === null){
            return null;
        }elseif(gettype($date) == 'integer' || gettype($date) == 'double' ){
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date))->format('Y-m-d');
        }else{
            return Carbon::parse($date)->format('Y-m-d');
        }
    }
}
