<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExpenceRequestUser extends BaseModel
{
    protected $fillable = ['expence_request_id', 'user_id'];
}
