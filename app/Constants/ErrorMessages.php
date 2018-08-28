<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 28/08/18
 * Time: 11:18 AM
 */

namespace App\Constants;


class ErrorMessages
{



    const INVALID_OPERATION = "invalid operation";

    /*
    * Task related
    */
    const TITLE_IS_REQUIRED = "title is required field";
    const INVALID_TASK_STATUS = "invalid task status";
    const ALREADY_CHANGED_STATUS = "task status is already in {status} state";
    const INVALID_TASK = "invalid task";
    const INVALID_TASK_PRIORITY = "invalid task priority , priority should be between 1 to 10";

    /*
     * User Related
     */
    const NAME_IS_REQUIRED = "name is required field and supports only [A-Z,a-z]";
    const INVALID_USER_ID = "invalid User Id";
    const INVALID_USER = "Invalid user";
    const INVALID_USER_EMAIL  = "invalid email";
    const INVALID_PHONE_NUMBER  = "invalid phone number";

}
