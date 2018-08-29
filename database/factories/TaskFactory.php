<?php

use App\Constants\TasksConstants;
use App\Models\Task;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        "title" => $faker->sentence,
        "description" => $faker->sentences(3, true),
        "status" => $faker->randomElement(TasksConstants::TaskAllowedStatus),
        "priority" => $faker->numberBetween(TasksConstants::MinimumTaskPriority,TasksConstants::MaximumTaskPriority),
        "user_id" =>  function(){
            return factory(User::class)->create()->user_id;
        }
    ];
});
