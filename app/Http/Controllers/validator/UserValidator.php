<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 2:21 PM
 */

namespace App\Http\Controllers\validator;


use App\Models\User;

class UserValidator
{
    static $createUsers = [
        User::name => 'required|string|max:100',
        User::phone => 'required|regex:/^[6-9]\d{9}$/',
        User::email => 'required|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/',
    ];

    static $updateUser = [
        User::name => 'required|string|max:100',
        User::phone => 'required|regex:/^[6-9]\d{9}$/',
        User::email => 'required|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/',
    ];
}
