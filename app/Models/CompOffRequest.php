<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;



class CompOffRequest extends BaseModel
{
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = ['id', 'financial_year_id', 'user_id', 'date', 'description', 'is_fullday', 'is_approved', 'approval_status', 'approval_by', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
}
