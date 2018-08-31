<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 6:27 PM
 */

namespace App\Http\Controllers\validator;


use App\Models\Task;
use App\Models\User;

class TaskValidator
{
      static  $createTasks = [
        Task::Title      => 'required|alpha_num|max:100',
        Task::Priority    => 'sometimes|int|min:1|max:10',
        User::userId          => 'required|exists:users,user_id',
        Task::Status            => 'sometimes|string|in:completed,pending',
        Task::Description       => 'sometimes|string'
    ];

    static  $updateTasks = [
        Task::Title     => 'required|alpha_num|max:100',
        Task::Priority  => 'sometimes|int|min:1|max:10',
        Task::Status    => 'sometimes|string|in:completed,pending',
        Task::Description => 'sometimes|string'
    ];

    static $displayTaskOfAUser = [
        User::userId          => 'required|exists:users,user_id',
    ];
}
