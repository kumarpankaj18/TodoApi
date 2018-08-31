<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Constants\ErrorMessages;
use App\Http\Controllers\validator\TaskValidator;
use App\Http\Controllers\validator\UserValidator;
use App\Http\Services\TasksService;
use App\Http\Services\UserService;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class TasksController extends Controller
{

    protected $service;
    protected $validator;
    protected $userService;

    public function __construct()
    {
        $this->service = new TasksService();
        $this->validator = new TaskValidator();
        $this->userService = new UserService();
    }

    /**
     * Display all  resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        $validator = Validator::make($request->all(), TaskValidator::$createTasks);
        if($validator->fails())
        {
            return response()->json( [ 'errors' => $validator->errors() ], 400 );
        }

        return response()->json($this->service->createOrUpdateTasks($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->service->getTaskById($id);
        if (($task === null))
        {
            return response()->json([ 'errors' => ErrorMessages::INVALID_TASK], 400);
        }

        return response()->json($task);
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
        $validator = Validator::make($request->all(), TaskValidator::$updateTasks);
        if($validator->fails())
        {
            return response()->json( [ 'errors' => $validator->errors() ], 400 );
        }

        $task = $this->service->getTaskById($id);
        if($task === null){
            return response()->json([ 'errors' => ErrorMessages::INVALID_TASK], 400);
        }
        return response()->json($this->service->createOrUpdateTasks($request, $task));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = $this->service->getTaskById($id);
        if($task === null){
            return response()->json([ 'errors' => ErrorMessages::INVALID_TASK], 400);
        }
        $this->service->deleteTask($task);
        return response()->json("", 204);
    }

    public function getUserTasks(String $userId)
    {
        $validator = Validator::make([User::userId => $userId], TaskValidator::$displayTaskOfAUser);
        if($validator->fails())
        {
            return response()->json( [ 'errors' => $validator->errors() ], 400 );
        }

        return $this->service->getUserTasks($userId);
    }
}
