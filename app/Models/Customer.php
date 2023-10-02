<?php

namespace App\Models;
// Site
use Carbon\Carbon;
use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use Auditable;
    use HasFactory;

    public $table = 'customers';

    protected $dates = [
        'register_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'phone_number',
        'address',
        'township_id',
        'ticket_no',
        'customer_code',
        'service_plan_id',
        'service_type_id',
        'site_lat',
        'site_long',
        'bandwidth',
        'register_date',
        'sales_voucher_no',
        'contact_person',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public function customerNameInvoices()
    {
        return $this->hasMany(Invoice::class, 'customer_name_id', 'id');
    }

    public function service_type()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function service_plan()
    {
        return $this->belongsTo(ServicePlan::class, 'service_plan_id');
    }

    public function township()
    {
        return $this->belongsTo(Township::class, 'township_id');
    }

    public function getRegisterDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format_2')) : null;
    }

    public function setRegisterDateAttribute($value)
    {
        $this->attributes['register_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    //get customer location
    public function location()
    {
        return $this->hasMany(CustomerLocation::class,'customer_id');
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
