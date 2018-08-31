<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public const PendingTaskStatus = "pending";
    public const Status = "status";
    public const MinimumTaskPriority = 1;
    public const createdAt = "created_at";
    public const TaskAllowedStatus = ["completed", "pending"];
    public const DefaultTaskPriority = 5;
    public const Description = "description";
    public const MaximumTaskPriority = 10;
    public const Priority = "priority";
    public const Title = "title";
    public const updatedAt = "updated_at";
    public const id = "id";

     public const updatable = [
        self::Status,
        self::Title,
        self::Description,
        self::Priority
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', User::userId, User::userId);
    }

    public function getDateFormat()
    {
        return 'U';
    }

    protected  $fillable = [
        self::Status,
        self::Title,
        self::Description,
        self::Priority,
        User::userId
    ];

    protected $default = [
        self::Status => self::PendingTaskStatus,
        self::Priority => 5
    ];

}
