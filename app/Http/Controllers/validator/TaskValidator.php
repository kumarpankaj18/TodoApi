<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 6:27 PM
 */

namespace App\Http\Controllers\validator;


use App\AppConstants;
use App\Models\Task;
use App\Models\User;
use App\TasksConstants;
use FlorianWolters\Component\Core\StringUtils;
use Illuminate\Http\Request;

class TaskValidator
{
    public static function  validateTaskCreateRequest(Request $request, User $user)
    {
        $validtionStatus = [];
        $validtionStatus[TasksConstants::Status] = AppConstants::Success;
        if(self::isInvalidUser($user))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "invalid user";
            return $validtionStatus;
        }

        if(self::isInvalidTaskTitle($request))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "title is required field";
            return $validtionStatus;
        }

        if(self::isInvalidStatus($request))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "status is required field and allowed values are ". implode(TasksConstants::TaskAllowedStatus, ",");
            return $validtionStatus;
        }

        return $validtionStatus;

    }

    public static function isInvalidUser($user)
    {
        return $user === null ;
    }

    public static function isInvalidTaskTitle(Request $request)
    {
        return StringUtils::isEmpty($request->input("title"));
    }

    public static function isInvalidStatus(Request $request)
    {
        $status = $request->input(TasksConstants::Status);
        return StringUtils::isEmpty($status) || !in_array($status,TasksConstants::TaskAllowedStatus);
    }

    public static function isInvalidValidPhone(Request $request)
    {
        $phone = $request->input("phone");
        return !(preg_match("^[6-9]\d{9}$", $phone));
    }

    public static function isInvalidTask(Task $task)
    {
        return $task === null;
    }
    public static function isInvalidTaskAndUserCombination(Task $task, User $user)
    {
        if(!(self::isInvalidTask($task) && (!self::isInvalidUser($user))))
        {
            return ($task->user_id !== $user->user_id) ;
        }

    }

    public static function  validateTaskUpdateRequest(Request $request, User $user, Task $task)
    {
        $validtionStatus = [];
        $validtionStatus[TasksConstants::Status] = AppConstants::Success;

        if(self::isInvalidTask($task))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "invalid task";
            return $validtionStatus;
        }
        if(self::isInvalidTaskAndUserCombination($task, $user)){
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "task belongs to different user";
            return $validtionStatus;
        }
        return self::validateTaskCreateRequest($request, $user);
    }

    public static function validateUpdateStatusTask(Request $request,User $user,Task $task)
    {
        $validtionStatus = [];
        $validtionStatus[TasksConstants::Status] = AppConstants::Success;

        if(self::isInvalidTaskAndUserCombination($task, $user)){
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "task belongs to different user";
            return $validtionStatus;
        }

        if(self::isInvalidStatus($request))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "status is required field and allowed values are ". implode(TasksConstants::TaskAllowedStatus, ",");
            return $validtionStatus;
        }
        $status = $request->input(TasksConstants::Status);
        if($task->status === $status){
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "task status is already in $status state";
            return $validtionStatus;
        }
        return $validtionStatus;

    }
}
