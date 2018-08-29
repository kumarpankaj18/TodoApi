<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 29/08/18
 * Time: 12:42 PM
 */

namespace Tests\Feature;


use App\Models\User;
use Tests\TestCase;
use GuzzleHttp\Client;
use App\Constants\AppConstants;
use App\Constants\ErrorMessages;
use App\Constants\TasksConstants;
use App\Constants\UsersConstants;

class TaskTest extends TestCase
{
    private $client ;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Client(['base_uri' => 'http://localhost:8000/']);
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function testTaskGetByIdSuccessCase()
    {
        $response = $this->get("/tasks/1");
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testTaskGetByIdForFailureCase()
    {
        $response = $this->get('/tasks/211');
        $response->assertStatus(404);
    }

    public function testTaskDeleteCaseForSuccessCase()
    {
        $response = $this->delete('/tasks/1');
        $response->assertStatus(200);
    }

    public function testTaskDeleteCaseForFailureCase()
    {
        $response = $this->delete('/tasks/211');
        $response->assertStatus(404);
    }

    public function testTaskCreateForFailureCase()
    {
        $response = $this->postJson('/tasks', []);
        $response->assertStatus(400);

    }

    public function testTaskGetSuccessCase()
    {
        $response = $this->get('/tasks', []);
        $response->assertStatus(200);
    }

    public function testTaskCreateFailureCaseInvalidUserId()
    {
        $response = $this->postJson('/tasks', [UsersConstants::userId=> "5b85495532736", TasksConstants::Title => "task4",
            TasksConstants::Description => "4th task", TasksConstants::Priority => 1, TasksConstants::Status => "pending"]);
        $response->assertStatus(400);
        $response->assertJson([TasksConstants::Status => AppConstants::Failure, AppConstants::Error => ErrorMessages::INVALID_USER_ID]);
    }

    public function testTaskCreateFailureCaseInvalidTitle()
    {
        $user = User::find(1);
        $response = $this->postJson('/tasks', [UsersConstants::userId=>$user ->user_id,
            TasksConstants::Description => "4th task", TasksConstants::Priority => 1, TasksConstants::Status => "pending"]);
        $response->assertStatus(400);
        $response->assertJson([TasksConstants::Status => AppConstants::Failure, AppConstants::Error => ErrorMessages::TITLE_IS_REQUIRED]);
    }

    public function testTaskCreateFailureCaseInvalidPriority()
    {
        $user = User::find(1);
        $response = $this->postJson('/tasks', [UsersConstants::userId=>$user ->user_id, TasksConstants::Title => "task4",
            TasksConstants::Description => "4th task", TasksConstants::Priority => 11, TasksConstants::Status => "pending"]);
        $response->assertStatus(400);
        $response->assertJson([TasksConstants::Status => AppConstants::Failure, AppConstants::Error => ErrorMessages::INVALID_TASK_PRIORITY]);
    }

    public function testTaskCreateSuccessCase()
    {
        $user = User::find(1);
        $response = $this->postJson('/tasks', [UsersConstants::userId=>$user ->user_id, TasksConstants::Title => "task4",
            TasksConstants::Description => "4th task", TasksConstants::Priority => 10, TasksConstants::Status => "pending"]);
        $response->assertStatus(200);
    }

    public function testForUser()
    {
        $user = User::find(1);
        $response = $this->postJson('/tasks', [UsersConstants::userId=>$user ->user_id, TasksConstants::Title => "task4",
            TasksConstants::Description => "4th task", TasksConstants::Priority => 10, TasksConstants::Status => "pending"]);
        $response->assertStatus(200);
        $response = $this->get("/user/$user->user_id/tasks");

        $response->assertJson(["pending" => [[UsersConstants::userId=>$user ->user_id, TasksConstants::Title => "task4",
            TasksConstants::Description => "4th task", TasksConstants::Priority => 10, TasksConstants::Status => TasksConstants::PendingTaskStatus]]]);
    }




}
