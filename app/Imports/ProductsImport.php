<?php

namespace App\Imports;

use App\Helpers\helper;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
    //   dd($row);
        $type = '';
        if($row['onu_typenew']){
            $type = 'new';
        }
        if($row['onu_typedual_bnd']){
            $type = 'dual_bnd';
        }
        if($row['onu_typeope']){
            $type = 'cpe';
        }
        return new Product([
            'onu_type'  =>  $type,
            'onu_model_no'  =>  $row['onu_model_no'],
            'ont_serial_no'  =>  $row['ont_serial_no'],
            'onu'  =>  $row['onu'],
            'drum_no'  =>  $row['drum_no'],
            'patch_cord'  =>  $row['patch_cord'],
            'drop_sleeve'  =>  $row['drop_sleeve'],
            'sleeve_holder'  =>  $row['sleeve_holder'],
            'product_name'  =>  $row['product_name'],
            'price'  =>  $row['price'],
            'stock_qty'  =>  $row['stock_qty'],
            'total_stock_qty'  =>  $row['stock_qty'],
            'length'            => $row['length'],
            'total_length'        => $row['length'],
            'discount'  =>  $row['discount'],
            'model_no'  =>  $row['model_no'],
            'description'  =>  $row['description'],
            'status'  =>  'in',
            // 'category_name_id'  =>  helper::getCategoryId($row['category_name'])
        ]);
    }
}
