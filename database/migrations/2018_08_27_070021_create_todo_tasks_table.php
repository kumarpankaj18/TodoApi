<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodoTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('description')->nullable();
            $table->uuid('user_id');
            $table->enum('status' , ["completed", "pending"]);
            $table->foreign("user_id")->references("user_id")->on("users");
            $table->index('user_id');

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
        Schema::dropIfExists('todo_tasks');
    }
}
