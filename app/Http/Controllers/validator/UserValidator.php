<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 2:21 PM
 */

namespace App\Http\Controllers\validator;



use FlorianWolters\Component\Core\StringUtils;
use Illuminate\Http\Request;

class UserValidator
{
    public static function  validateUserUpdateRequest(Request $request, $user)
    {
        $validtionStatus = [];
        $validtionStatus["status"] = "success";
        if(self::isInvalidUser($user)){
            $validtionStatus["status"] = "failure";
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
        $validtionStatus["status"] = "success";
        if(self::isInvalidValidUserName($request)){
            $validtionStatus["status"] = "failure";
            $validtionStatus["error"] = "name is required field";
            return $validtionStatus;
        }

        if(self::isInvalidValidEmail($request)){
            $validtionStatus["status"] = "failure";
            $validtionStatus["error"] = "email is required field";
            return $validtionStatus;
        }

        if(self::isInvalidValidPhone($request)){
            $validtionStatus["status"] = "failure";
            $validtionStatus["error"] = "phone is required field";
            return $validtionStatus;
        }

    }
}
