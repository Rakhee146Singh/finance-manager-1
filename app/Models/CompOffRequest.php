<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use App\Models\BaseModel;


class CompOffRequest extends BaseModel
{
    use UuidTrait;
    protected $keyType      = 'string';
    protected $primaryKey   = 'id';
    public $incrementing    = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable     = [
        'id',
        'financial_year_id',
        'user_id',
        'date',
        'description',
        'is_fullday',
        'is_approved',
        'approval_status',
        'approval_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    /**
     *Expence Belongs to  users
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
