<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 27/08/18
 * Time: 2:18 PM
 */

namespace App\Http\Services;

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

    public function getAllTasks() :array
    {
        return ["data" => User::all()];
    }

    public function getUserByUserId(String $userId)
    {
        if ($userId === null)
        {
            return null;
        }

        return User::where(User::userId, $userId)->first();
    }

    public function deleteUser(User $user)
    {
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
        $data = $request->all();
        $user->fill($data);
        $user->save();

        return $user;
    }


}
