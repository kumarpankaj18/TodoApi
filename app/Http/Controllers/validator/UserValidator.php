<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 2:21 PM
 */

namespace App\Http\Controllers\validator;



use App\Constants\AppConstants;
use App\Constants\TasksConstants;
use FlorianWolters\Component\Core\StringUtils;
use Illuminate\Http\Request;
use App\Constants\UsersConstants;

class UserValidator
{
    public static function  validateUserUpdateRequest(Request $request, $user)
    {
        $validtionStatus = [];
        $validtionStatus[TasksConstants::Status] = AppConstants::Success;
        if(self::isInvalidUser($user)){
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "invalid user";
            return $validtionStatus;
        }

        return self::validateUserCreateRequest($request);

    }

    public static function isInvalidUser($user)
    {
        return $user === null ;
    }

    public static function isInvalidUserId(Request $request)
    {
        $user_id = $request->input(UsersConstants::userId);
        return StringUtils::isEmpty($user_id);
    }

    public static function isInvalidValidUserName(Request $request)
    {
        $userName = $request->input("name");
        return !preg_match("/^[a-zA-Z ]*$/", $userName);
    }

    public static function isInvalidValidEmail(Request $request)
    {
        $email = $request->input("email");
        return !filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isInvalidValidPhone(Request $request)
    {
        $phone = $request->input("phone");
        return !(preg_match("^[6-9]\d{9}$", $phone));
    }

    public static function  validateUserCreateRequest(Request $request)
    {
        $validtionStatus = [];
        $validtionStatus[TasksConstants::Status] = AppConstants::Success;
        if(self::isInvalidValidUserName($request)){
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "name is required field";
            return $validtionStatus;
        }

        if(self::isInvalidValidEmail($request)){
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "email is required field";
            return $validtionStatus;
        }

        if(self::isInvalidValidPhone($request)){
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus["error"] = "phone is required field";
            return $validtionStatus;
        }

    }
}
