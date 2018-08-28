<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 6:26 PM
 */

namespace App\Http\Services;

use App\Constants\AppConstants;
use App\Constants\TasksConstants;
use App\Constants\UsersConstants;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksService
{
    public function createOrUpdateTasks(Request $request, Task $task = null)
    {
        if ($task == null)
        {
            $task = new Task();
            $task->user_id = $request->input(UsersConstants::userId);
        }
        $task->title = $request->input(TasksConstants::Title);
        $task->description = $request->input(TasksConstants::Description);
        $status  =  $request->input(TasksConstants::Status);
        $task->status = $status !=null  ? $status : TasksConstants::PendingTaskStatus;
        $task->priority =  $request->input(TasksConstants::Priority);
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

    public function deleteTask(int $id)
    {
        $task = Task::findOrFail($id);

        return $task->delete();

    }

    public function getAllTasks()
    {
        return Task::all();
    }

    public function getUserTasks(String $userId)
    {

        $tasks = $this->getTaskListForAUser($userId);

        $result = [];
        foreach ($tasks as $task)
        {
            if (array_get($result, $task->status) === null)
            {
                $result[$task->status] = [];
            }
            array_push($result[$task->status], $task);
        }

        return $result;
    }

    /**
     * @param String $userId
     * @return array of taks
     */
    public function getTaskListForAUser(String $userId)
    {
        $tasks = Task::where(UsersConstants::userId, $userId)
            ->orderBy(TasksConstants::Status, AppConstants::SortDESC)
            ->orderBy(TasksConstants::Priority, AppConstants::SortASC)
            ->get();

        return $tasks;
    }

}
