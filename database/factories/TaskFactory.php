<?php

use App\Models\Task;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        "title" => $faker->sentence,
        "description" => $faker->sentences(3, true),
        "status" => $faker->randomElement(Task::TaskAllowedStatus),
        "priority" => $faker->numberBetween(Task::MinimumTaskPriority, Task::MaximumTaskPriority),
        "user_id" =>  function(){
            return factory(User::class)->create()->user_id;
        }
    ];
});
