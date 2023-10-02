<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvoiceProduct extends Model
{
    use HasFactory;
    protected $table = "invoice_product";
    protected $fillable = [
        'invoice_id',
        'product_id',
        'qty',
        'service_fees',
        'discount',
        'total'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function invoices(){
        return $this->hasOne(Invoice::class,'id','invoice_id')->withDefault();
    }

    public function products(){
        return $this->hasMany(Product::class,'id','product_id');
    }

    public function serviceAssign(){
        return $this->hasOneThrough(CustomerAssign::class,Invoice::class,'customer_assign','id','invoice_id','id')->withDefault();
    }

    public function customer(){
        return $this->hasOneThrough(Customer::class,Invoice::class,'customer_name_id','id','invoice_id','id')->withDefault();
    }
}
