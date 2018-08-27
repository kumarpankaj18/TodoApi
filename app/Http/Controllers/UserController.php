<?php

namespace App\Http\Controllers;

use App\Http\Controllers\validator\UserValidator;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;
use Psy\Util\Str;

class UserController extends Controller
{

    protected  $service ;
    protected  $validator;
    public function __construct()
    {
        $this->service = new UserService();
        $this->validator = new UserValidator();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filteredRequest = $this->validator->validateUserCreateRequest($request);
        if($filteredRequest["status"] === "failure")
        {
            return response()->json($filteredRequest,400);
        }
        return response()->json($this->service->createOrUpdateUser($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->service->getUserById($id);
        if(($user === null) || ($user === "")){
            return response($user, 404);
        }

        return response()->json($user);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->service->getUserById($id);
        $filteredRequest = $this->validator->validateUserUpdateRequest($request, $user);
        if($filteredRequest["status"] === "failure")
        {
            return response()->json($filteredRequest,400);
        }
        return response()->json($this->service->createOrUpdateUser($request, $user));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->service->deleteUser($id);
        return response()->json("",200);
    }
}
