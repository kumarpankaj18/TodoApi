<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('title',100);
            $table->string('description')->nullable();
            $table->uuid('user_id');
            $table->enum('status' , ["completed", "pending"]);
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
