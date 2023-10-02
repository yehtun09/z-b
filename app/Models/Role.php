<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'roles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        if ($this->title == 'Admin') {
            return true;
        }

        return false;
    }
    public function getIsAdministratorAttribute()
    {
        if ($this->title == 'Administrator') {
            return true;
        }

        return false;
    }
    public function getIsEngineerAttribute()
    {
        if ($this->title == 'Engineer') {
            return true;
        }

        return false;
    }
}
