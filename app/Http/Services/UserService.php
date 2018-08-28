<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 2:18 PM
 */

namespace App\Http\Services;

use App\Constants\UsersConstants;
use App\Models\User;
use Illuminate\Http\Request;

class UserService
{

    public function getUserById(int $id)
    {
        if ($id === null)
        {
            return null;
        }

        return User::find($id);
    }

    public function getAllTasks()
    {
        return User::all();
    }

    public function getUserByUserId(String $userId)
    {
        if ($userId === null)
        {
            return null;
        }

        return User::where(UsersConstants::userId, $userId)->first();
    }

    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);
        if ($user != null)
        {
            return $user->delete();
        }
    }

    public function createOrUpdateUser(Request $request, $user = null)
    {
        if ($user == null)
        {
            $user = new User();
            $user->user_id = uniqid();
        }
        $user->name = $request->input(UsersConstants::name);
        $user->email = $request->input(UsersConstants::email);
        $user->phone = $request->input(UsersConstants::phone);
        $user->save();

        return $user;
    }


}
