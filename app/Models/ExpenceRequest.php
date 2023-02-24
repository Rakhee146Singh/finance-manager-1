<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenceRequest extends BaseModel
{
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = ['financial_year_id', 'user_id', 'date', 'amount', 'attachment', 'description', 'is_approved', 'approval_status', 'approval_by', 'created_by', 'updated_by', 'deleted_by'];
    public function users()
    {
        return $this->belongsToMany(User::class, 'expence_request_users', 'expence_request_id', 'user_id');
    }
}
