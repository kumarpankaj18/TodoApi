<?php

namespace App\Models;

use App\Constants\UsersConstants;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function tasks()
    {
        return $this->hasMany('App\Models\Task', UsersConstants::userId, UsersConstants::userId);
    }
}
