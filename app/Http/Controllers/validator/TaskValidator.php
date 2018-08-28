<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 6:27 PM
 */

namespace App\Http\Controllers\validator;


use App\Constants\AppConstants;
use App\Constants\ErrorMessages;
use App\Constants\TasksConstants;
use App\Models\Task;
use App\Models\User;
use FlorianWolters\Component\Core\StringUtils;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;

class TaskValidator
{
    public static function validateTaskUpdateRequest(Request $request, User $user, Task $task)
    {
        $validtionStatus = [];
        $validtionStatus[TasksConstants::Status] = AppConstants::Success;

        if (self::isInvalidTask($task))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::INVALID_TASK;

            return $validtionStatus;
        }
        if (self::isInvalidTaskAndUserCombination($task, $user))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::INVALID_OPERATION;

            return $validtionStatus;
        }

        return self::validateTaskCreateRequest($request, $user);
    }

    public static function isInvalidTask(Task $task)
    {
        return $task === null;
    }

    public static function isInvalidTaskAndUserCombination(Task $task, User $user)
    {
        if (!(self::isInvalidTask($task) && (!self::isInvalidUser($user))))
        {
            return ($task->user_id !== $user->user_id);
        }

    }

    public static function isInvalidUser($user)
    {
        return $user === null;
    }

    public static function validateTaskCreateRequest(Request $request, User $user = null)
    {
        $validtionStatus = [];
        $validtionStatus[TasksConstants::Status] = AppConstants::Success;
        if (self::isInvalidUser($user))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::INVALID_USER_ID;

            return $validtionStatus;
        }

        if (self::isInvalidTaskTitle($request))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::TITLE_IS_REQUIRED;
            return $validtionStatus;
        }

        if (self::isInvalidStatus($request))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::INVALID_TASK_STATUS;

            return $validtionStatus;
        }
        if (self::isInvalidPriority($request))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::INVALID_TASK_PRIORITY;

            return $validtionStatus;
        }

        return $validtionStatus;

    }

    public static function isInvalidPriority(Request $request){
        $priority = $request->input(TasksConstants::Priority);

        return $priority !=null and
            !(is_int($priority) and
                (($priority <= TasksConstants::MaximumTaskPriority) and (TasksConstants::MinimumTaskPriority <= $priority)));
    }

    public static function isInvalidTaskTitle(Request $request)
    {
        return StringUtils::isEmpty($request->input(TasksConstants::Title));
    }

    public static function isInvalidStatus(Request $request)
    {
        $status = $request->input(TasksConstants::Status);

        return !StringUtils::isEmpty($status) and !in_array($status, TasksConstants::TaskAllowedStatus);
    }

    public static function validateUpdateStatusTask(Request $request, User $user, Task $task)
    {
        $validtionStatus = [];
        $validtionStatus[TasksConstants::Status] = AppConstants::Success;

        if (self::isInvalidTaskAndUserCombination($task, $user))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] =  ErrorMessages::INVALID_OPERATION;

            return $validtionStatus;
        }

        if (self::isInvalidStatus($request))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::INVALID_TASK_STATUS;

            return $validtionStatus;
        }
        $status = $request->input(TasksConstants::Status);
        if ($task->status === $status)
        {
            $variables = array('{status}' => $status);
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = strtr(ErrorMessages::ALREADY_CHANGED_STATUS, $variables);

            return $validtionStatus;
        }

        return $validtionStatus;

    }
}
