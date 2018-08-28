<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 2:21 PM
 */

namespace App\Http\Controllers\validator;


use App\Constants\AppConstants;
use App\Constants\ErrorMessages;
use App\Constants\TasksConstants;
use App\Constants\UsersConstants;
use FlorianWolters\Component\Core\StringUtils;
use Illuminate\Http\Request;

class UserValidator
{
    public static function validateUserUpdateRequest(Request $request, $user)
    {
        $validtionStatus = [];
        $validtionStatus[TasksConstants::Status] = AppConstants::Success;
        if (self::isInvalidUser($user))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::INVALID_USER;

            return $validtionStatus;
        }

        return self::validateUserCreateRequest($request);

    }

    public static function isInvalidUser($user)
    {
        return $user === null;
    }

    public static function validateUserCreateRequest(Request $request)
    {
        $validtionStatus = [];
        $validtionStatus[TasksConstants::Status] = AppConstants::Success;
        if (self::isInvalidValidUserName($request))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::NAME_IS_REQUIRED;
            return $validtionStatus;
        }

        if (self::isInvalidValidEmail($request))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::INVALID_USER_EMAIL;

            return $validtionStatus;
        }

        if (self::isInvalidValidPhone($request))
        {
            $validtionStatus[TasksConstants::Status] = AppConstants::Failure;
            $validtionStatus[AppConstants::Error] = ErrorMessages::INVALID_PHONE_NUMBER;

            return $validtionStatus;
        }

    }

    public static function isInvalidValidUserName(Request $request)
    {
        $userName = $request->input(UsersConstants::name);

        return StringUtils::isEmpty($userName) or !preg_match("/^[a-zA-Z ]+$/", $userName);
    }

    public static function isInvalidValidEmail(Request $request)
    {
        $email = $request->input(UsersConstants::email);

        return StringUtils::isEmpty($email) or !filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isInvalidValidPhone(Request $request)
    {
        $phone = $request->input(UsersConstants::phone);

        return StringUtils::isEmpty($phone) or !(preg_match("/^[6-9]\d{9}$/", $phone));
    }

    public static function isInvalidUserId(Request $request)
    {
        $user_id = $request->input(UsersConstants::userId);

        return StringUtils::isEmpty($user_id);
    }
}
