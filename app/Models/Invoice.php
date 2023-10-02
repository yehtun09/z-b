<?php

namespace App\Models;
// SiteInformation
use Carbon\Carbon;
use \DateTimeInterface;
use App\Traits\Auditable;
use App\Models\CustomerAssign;
use Spatie\MediaLibrary\HasMedia;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Invoice extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use HasFactory;
    use Auditable;
    use InteractsWithMedia;

    public const CUSTOMER_ACCEPTANCE_FORM_RADIO = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    public const INVOICE_STATUS_RADIO = [
        '1' => 'Paid',
        '0' => 'Unpaid',
    ];

    protected $appends = [
        'odb',
        'onu',
        'ssr',
    ];

    public const INVOICE_STATUS_SELECT = [
        '1' => 'Pending',
        '2' => 'Completed',
        '3' => 'Suspend',
        '4' => 'Cancel',
    ];

    public const PATCH_CORD_TYPE = [
        'upc_3m' => 'SC/UPC-SC/UPC-3M',
        'upc_1m' => 'SC/UPC-SC/UPC-1M',
        'apc_3m' => 'SC/UPC-SC/APC-3M',
        'apc_1m' => 'SC/UPC-SC/APC-1M',
    ];

    public $table = 'invoices';

    protected $dates = [
        'assign_date',
        'suspend_date',
        'finished_date',
        'start_date',
        'end_date',
        'issue_date',
        'received_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'odb_no',
        'odb_lat',
        'odb_long',
        'odb_splitter_no',
        'odb_splitter_pair_no',
        'ont_received_power',
        'olt_name',
        'assign_date',
        'start_date',
        'end_date',
        'suspend_date',
        'finished_date',
        'user_id',
        'installation_period',
        'resolution',
        'start_meter',
        'end_meter',
        'drop_cable_length',
        'cable_drum_no',
        'drop_sleeve_pcs',
        'core_jc_sleeve_holder_pcs',
        'patch_cord',
        'cable_tiles_pcs',
        'label_tape_rol',
        'onu_sticker',
        'customer_acceptance_form',
        'issue_date',
        'customer_name_id',
        'created_at',
        'customer_assign',
        'invoice_status',
        'total_qty',
        'sub_total',
        'total',
        'total_amount',
        'received_total_amount',
        'received_date',
        'remark',
        'sale_person_remark',
        'installation_remark',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'update_status'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }
    

    public function getOdbAttribute()
    {
        $files = $this->getMedia('odb');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }

    public function getOnuAttribute()
    {
        $file = $this->getMedia('onu')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getSsrAttribute()
    {
        $file = $this->getMedia('ssr')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function customer_name()
    {
        return $this->belongsTo(Customer::class, 'customer_name_id')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function customerAssign()
    {
        return $this->belongsTo(CustomerAssign::class, 'customer_assign')->withDefault();
    }

    // public function getAssignDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format_2')) : null;
    // }

    // public function setAssignDateAttribute($value)
    // {
    //     $this->attributes['assign_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    // public function getSuspendDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format_2')) : null;
    // }

    // public function setSuspendDateAttribute($value)
    // {
    //     $this->attributes['suspend_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }
    
    // public function getFinishedDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format_2')) : null;
    // }

    // public function setFinishedDateAttribute($value)
    // {
    //     $this->attributes['finished_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    // public function getIssueDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format_2')) : null;
    // }

    // public function setIssueDateAttribute($value)
    // {
    //     $this->attributes['issue_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    // public function getReceivedDateAttribute($value)
    // {
    //     return $value ? Carbon::parse($value)->format(config('panel.date_format_2')) : null;
    // }

    // public function setReceivedDateAttribute($value)
    // {
    //     $this->attributes['received_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    // }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['qty', 'service_fees', 'discount', 'total']);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function service_person()
    {
        return $this->hasOneThrough(User::class, CustomerAssign::class, 'service_person_id', 'id', 'customer_assign', 'id');
    }
}