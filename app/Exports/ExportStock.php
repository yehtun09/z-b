<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportStock implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $products = Product::with(['created_by'])->whereNull('parent_id')->latest()->get();
        // dd($products);
        $productList = [];
        foreach($products as $product){
            array_push($productList,[
                'onu_type'=>$product->onu_type ?? '',
                'onu_model_no'=>$product->onu_model_no ?? '',
                'ont_serial_no'=>$product->ont_serial_no ?? '',
                'onu'=>$product->onu ?? '',
                'drum_no'=>$product->drum_no ?? '',
                'patch_cord'=>$product->patch_cord ?? '',
                'drop_sleeve'=>$product->drop_sleeve ?? '',
                'sleeve_holder'=>$product->sleeve_holder ?? '',
                'product_name'=>$product->product_name ?? '',
                'model_no'=>$product->model_no ?? '-',
                'price'=>(int)$product->price ?? '',
                'total_stock_qty'=>$product->total_stock_qty ?? '',
                'length'=>$product->total_length ?? '',
                'discount'=>$product->discount ?? '',
                'description'=>$product->description ?? '',
            ]);
        }
        return collect($productList);
    }

    public function headings(): array
    {
        return [
            trans('cruds.product.fields.onu_type'),
            trans('cruds.product.fields.onu_model_no'),
            trans('cruds.product.fields.ont_serial_no'),
            trans('cruds.product.fields.onu'),
            trans('cruds.product.fields.drum_no'),
            trans('cruds.product.fields.patch_cord'),
            trans('cruds.product.fields.drop_sleeve'),
            trans('cruds.product.fields.sleeve_holder'),
            trans('cruds.product.fields.product_name'),
            trans('cruds.product.fields.model_no'),
            trans('cruds.product.fields.price'),
            trans('cruds.product.fields.stock_qty'),
            trans('cruds.product.fields.length'),
            trans('cruds.product.fields.discount'),
            trans('cruds.product.fields.description'),
        ];
    }
}
