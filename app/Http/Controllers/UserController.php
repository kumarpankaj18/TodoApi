<?php

namespace App\Http\Controllers;


use App\Constants\AppConstants;
use App\Constants\ErrorMessages;
use App\Http\Controllers\validator\UserValidator;
use App\Http\Services\UserService;
use App\Models\Task;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{

    protected $service;
    protected $validator;

    public function __construct()
    {
        $this->service = new UserService();
        $this->validator = new UserValidator();
    }

    public function index()
    {
        return response()->json($this->service->getAllTasks());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), UserValidator::$createUsers);
        if($validator->fails())
        {
            return response()->json( [ AppConstants::Errors => $validator->errors() ], 400 );
        }

        return response()->json($this->service->createOrUpdateUser($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->service->getUserById($id);
        if ($user === null)
        {
            return response([ AppConstants::Errors => ErrorMessages::INVALID_USER_ID], 400);
        }

        return response()->json($user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), UserValidator::$updateUser);
        if($validator->fails())
        {
            return response()->json( [ AppConstants::Errors => $validator->errors() ], 400 );
        }
        $user = $this->service->getUserById($id);

        return response()->json($this->service->createOrUpdateUser($request, $user));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->service->getUserById($id);
        if($user === null){
            return response()->json([ AppConstants::Errors => ErrorMessages::INVALID_USER_ID], 400);
        }
        $this->service->deleteUser($user);
        return response()->json("", 204);
    }
}
