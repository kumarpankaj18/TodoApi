<?php

use App\Models\Task;
use App\Models\User;
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
            $table->string(Task::Title, 100);
            $table->text(Task::Description)->nullable();
            $table->uuid(User::userId);
            $table->string(Task::Status, 20)->default(Task::PendingTaskStatus);
            $table->foreign(User::userId)->references(User::userId)->on("users");
            $table->index(User::userId);
            $table->integer(User::createdAt);
            $table->integer(User::updatedAt);
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
