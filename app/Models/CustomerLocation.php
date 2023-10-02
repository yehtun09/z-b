<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CustomerLocation extends Model
{
    use HasFactory;
    public $table = 'customer_location';


    protected $appends = [
        'label',
        'draggable',
        'position',
    ];
    protected $fillable = [

        'customer_id',
        'area_site_lat',
        'area_site_long'
    ];


    public function getLabelAttribute()
    {
        return ['color' => 'white', 'text' => 'P'];
    }

    public function getDraggableAttribute()
    {
        return true;
    }



    protected function getpositionAttribute()
    {
        return [
                "lat" => (float)$this->area_site_lat,
                "lng" => (float)$this->area_site_long
        ];
    }



}
