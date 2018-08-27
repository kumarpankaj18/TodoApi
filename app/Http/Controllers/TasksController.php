<?php

namespace App\Http\Controllers;

use App\Constants\AppConstants;
use App\Http\Controllers\validator\TaskValidator;
use App\Http\Controllers\validator\UserValidator;
use App\Http\Services\TasksService;
use App\Http\Services\UserService;
use App\Constants\TasksConstants;
use App\Constants\UsersConstants;
use Illuminate\Http\Request;

class TasksController extends Controller
{

    protected  $service ;
    protected  $validator;
    protected  $userService;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if(UserValidator::isInvalidUserId($request))
        {
            return $this->handleInvalidUserIdCase();
        }
        $user = $this->userService->getUserByUserId($request->input(UsersConstants::userId));
        $filteredRequest = $this->validator->validateTaskCreateRequest($request, $user);
        if($filteredRequest[TasksConstants::Status] === AppConstants::Failure)
        {
            return response()->json($filteredRequest,400);
        }
        return response()->json($this->service->createOrUpdateTasks($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->service->getTaskById($id);
        if(($task === null)){
            return response($task, 404);
        }

        return response()->json($task);
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
        if(UserValidator::isInvalidUserId($request))
        {
            return $this->handleInvalidUserIdCase();
        }
        $user = $this->userService->getUserByUserId($request->input(UsersConstants::userId));
        $task = $this->service->getTaskById($id);
        $filteredRequest = $this->validator->validateTaskCreateRequest($request, $user);
        if($filteredRequest[TasksConstants::Status] === AppConstants::Failure)
        {
            return response()->json($filteredRequest,400);
        }
        return response()->json($this->service->createOrUpdateTasks($request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->service->deleteUser($id);
    }

    public function getUserTasks(String $userId)
    {
        $user = $this->userService->getUserByUserId($userId);
        if(TaskValidator::isInvalidUser($user))
        {
            $filteredRequest[TasksConstants::Status] = AppConstants::Failure;
            $filteredRequest["error"]  = "invalid user id";
            return $filteredRequest;
        }
        return $this->service->getUserTasks($userId);
    }

    public function updateTaskStatus(Request $request, int $taskId)
    {
        if(UserValidator::isInvalidUserId($request))
        {
            return $this->handleInvalidUserIdCase();
        }
        $user = $this->userService->getUserByUserId($request->input(UsersConstants::userId));
        $task = $this->service->getTaskById($taskId);
        $filteredRequest = $this->validator->validateUpdateStatusTask($request, $user, $task);
        if($filteredRequest[TasksConstants::Status] === AppConstants::Failure)
        {
            return response()->json($filteredRequest,400);
        }
        return response()->json($this->service->updateTaskStatus($task, $request));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleInvalidUserIdCase(): \Illuminate\Http\JsonResponse
    {
        $filteredRequest = [];
        $filteredRequest[TasksConstants::Status] = AppConstants::Failure;
        $filteredRequest["error"] = "invalid user id";
        return response()->json($filteredRequest, 400);
    }
}
