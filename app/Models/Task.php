<?php

namespace App\Models;

use App\Constants\UsersConstants;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{


    public function user()
    {
        return $this->belongsTo('App\Models\User', UsersConstants::userId, UsersConstants::userId);
    }
}
