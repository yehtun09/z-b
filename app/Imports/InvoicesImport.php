<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;

class InvoicesImport implements WithHeadingRow, ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $customer_id = Customer::where('customer_code',$row['customer_code'])->first()->id;

        $assign_team = User::select('id')
        ->where('name', 'like', '%' . $row['assign_team'] . '%')
        ->first();

        if($row['cable_drum_no'])
        {
            $products = Product::where('drum_no' , $row['cable_drum_no'])->first();
            $products_length = $products->total_length - $row['drop_cable_length'] ;
            $products->update(['total_length' => $products_length]);
        }

        return new Invoice([
            'customer_name_id' => $customer_id,
            'odb_lat' => $row['odb_latitude'] ?? '',
            'odb_long' => $row['odb_longitude'] ?? '',
            'odb_no' => $row['odb_no'] ?? '',
            'odb_splitter_no' => $row['odb_splitter_no'] ?? '',
            'odb_splitter_pair_no' => $row['odb_splitter_pair_no'] ?? '',
            'ont_received_power' => $row['ont_received_power'] ?? '',
            'olt_name' => $row['olt_name'] ?? '',
            'user_id' => $assign_team->id ?? null ,
            'installation_period' => $row['installation_period'] ?? '',
            'resolution' => $row['resolution'] ?? '',
            'cable_drum_no' => $row['cable_drum_no'] ?? 0,
            'start_meter' => $row['start_meter'] ?? 0,
            'end_meter' => $row['end_meter'] ?? 0,
            'drop_cable_length' => $row['drop_cable_length'] ?? 0,
            'drop_sleeve_pcs' => $row['drop_sleeve_pcs'] ?? 0,
            'core_jc_sleeve_holder_pcs' => $row['1_core_jc_sleeve_holderpcs'] ?? 0,
            'patch_cord' => $row['patch_cord'] ?? '',
            'cable_tiles_pcs' => $row['cable_tiespcs'] ?? '',
            'label_tape_rol' => $row['label_taperoll'] ?? '',
            'onu_sticker' => $row['onu_sticker'] ?? '',
            'customer_acceptance_form' => $row['customer_acceptance_form'] ?? '',
            'sale_person_remark' => $row['sale_person_remark'] ?? '',
            'installation_remark' => $row['installation_remark'] ?? '',
            'issue_date' => $row['issue_date'] ? $this->getDate($row['issue_date']) : null,
        ]);
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
