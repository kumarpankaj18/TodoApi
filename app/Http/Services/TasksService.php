<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 6:26 PM
 */

namespace App\Http\Services;

use App\Constants\AppConstants;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TasksService
{
    public function createOrUpdateTasks(Request $request, Task $task = null)
    {
        if ($task == null)
        {
            $task = new Task($request->all());
            $task->user_id = $request->input(User::userId);
        } else
        {
            $task->fill($request->only(Task::updatable));
        }

        $task->save();

        return $task;
    }

    public function getTaskById(int $id)
    {
        if ($id === null)
        {
            return null;
        }

        return Task::find($id);
    }

    public function deleteTask(Task $task)
    {
        if($task !== null)
        {
            return $task->delete();
        }

    }

    public function getAllTasks() :array
    {
        return ["data" =>Task::all()];
    }

    public function getUserTasks(String $userId) :array
    {

        $tasks = $this->getTaskListForAUser($userId);

        $result = ["data" => $tasks];

        return $result;
    }

    /**
     * @param String $userId
     * @return array of taks
     */
    public function getTaskListForAUser(String $userId)
    {
        $tasks = Task::where(User::userId, $userId)
            ->orderBy(Task::Status, AppConstants::SortDESC)
            ->orderBy(Task::Priority, AppConstants::SortASC)
            ->get();

        return $tasks;
    }

}
