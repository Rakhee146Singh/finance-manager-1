<?php

namespace App\Models;

use App\Http\Traits\UuidTrait;
use App\Models\BaseModel;


class ExpenseRequest extends BaseModel
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
        'financial_year_id',
        'user_id',
        'date',
        'amount',
        'attachment',
        'description',
        'is_approved',
        'approval_status',
        'approval_by',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    /**
     *Expence Belongs to many users
     *
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
