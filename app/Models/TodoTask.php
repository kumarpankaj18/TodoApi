<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoTask extends Model
{
    //

    public function user()
    {
        return $this->belongsTo('App\Models\User',"user_id","user_id");
    }
}
