<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public const createdAt = "created_at";
    public const phone = "phone";
    public const name = "name";
    public const userId = "user_id";
    public const email = "email";
    public const updatedAt = "updated_at";



    protected $fillable = [
        self::name,
        self::email,
        self::phone
    ];


    public function tasks()
    {
        return $this->hasMany('App\Models\Task', self::userId, self::userId);
    }
    public function getDateFormat()
    {
        return 'U';
    }
}
