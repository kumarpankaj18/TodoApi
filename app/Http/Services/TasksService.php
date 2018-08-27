<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 6:26 PM
 */

namespace App\Http\Services;

use App\UsersConstants;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksService
{
    public function createOrUpdateTasks(Request $request, Task $task = null)
    {
        if($task == null){
            $task = new Task();
            $task->user_id = $request->input(UsersConstants::userId);
        }
        $task->title = $request->input("title");
        $task->description = $request->input("description");
        $task->status = $request->input("status");
        $task->save();
        return $task;
    }

    public function getTaskById(int $id)
    {
        if($id === null)
        {
            return null;
        }
        return Task::find($id);
    }

    public function deleteTask(int $id)
    {
        $task = Task::findOrFail($id);
        return $task->delete();

    }

    public function updateTaskStatus($task, $request)
    {
        $task->status = $request->input(TasksConstants::Status);
        $task->save();
        return $task;
    }

    public function  getAllTasks()
    {
        return Task::all();
    }

    public function getUserTasks(String $userId){
        return Task::where('user_id', $userId)
                    ->orderBy('status','desc')
                    ->orderBy('created_at', 'asc')
                    ->get();
    }
}
