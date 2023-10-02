<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    // use MultiTenantModelTrait;
    use Auditable;
    use HasFactory;

    public $table = 'products';

    public const ONU_LISTS = [
        'dual_bnd'  => 'Dual Bnd',
        'new'       => 'New',
        'cpe'       => 'CPE',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        // 'category_name_id',
        'onu_type',
        'onu_model_no',
        'ont_serial_no',
        'onu',
        'drum_no',
        'patch_cord',
        'drop_sleeve',
        'sleeve_holder',
        'product_name',
        'price',
        'stock_qty',
        'total_stock_qty',
        'length',
        'total_length',
        'created_at',
        'discount',
        'description',
        'model_no',
        'parent_id',
        'status',
        'site_id',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public function productInvoices()
    {
        return $this->belongsToMany(Invoice::class,'invoice_product','product_id','invoice_id');
    }


    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
