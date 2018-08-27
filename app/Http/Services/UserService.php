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
use phpDocumentor\Reflection\Types\Integer;
use Prophecy\Util\StringUtil;

class UserService
{

    public function getUserById(int $id)
    {
        if($id === null)
        {
            return null;
        }
        return User::find($id);
    }

    public function getUserByUserId(String $userId)
    {
        if($userId === null)
        {
            return null;
        }
        return User::where("user_id" , $userId);
    }

    public function deleteUser(int $id){
        $user = User::findOrFail($id);
        if($user != null)
        {
            return $user->delete();
        }
    }

    public function createOrUpdateUser(Request $request, $user = null)
    {
        if($user == null){
            $user = new User();
            $user->user_id = uniqid();
        }
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->phone = $request->input("phone");
        $user->save();
        return $user;
    }


}
