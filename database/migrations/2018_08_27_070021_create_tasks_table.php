<?php

use App\Constants\TasksConstants;
use App\Constants\UsersConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('description')->nullable();
            $table->uuid('user_id');
            $table->enum('status', TasksConstants::TaskAllowedStatus);
            $table->foreign(UsersConstants::userId)->references(UsersConstants::userId)->on("users");
            $table->index(UsersConstants::userId);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
