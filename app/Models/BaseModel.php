<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public $incrementing    = false;
    /**
     *Use Boot Method For Generating uuid & get user id for created by & updated by
     *
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
                $model->created_by = auth()->user()->id;
            }
        });
        static::updating(function ($model) {
            $model->updated_by = auth()->user()->id;
        });
    }
}
