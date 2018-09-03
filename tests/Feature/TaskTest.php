<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 29/08/18
 * Time: 12:42 PM
 */

namespace Tests\Feature;


use App\Constants\AppConstants;
use App\Constants\ErrorMessages;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        //$this->artisan('migrate:fresh');
       // $this->artisan('db:seed');
    }
    public function testTaskGetByIdSuccessCase()
    {
        $response = $this->get("/tasks/1");
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testTaskGetByIdForFailureCase()
    {
        $response = $this->get('/tasks/211');
        $response->assertStatus(400);
    }

    public function testTaskDeleteCaseForSuccessCase()
    {
        $response = $this->delete('/tasks/1');
        $response->assertStatus(204);
    }

    public function testTaskDeleteCaseForFailureCase()
    {
        $response = $this->delete('/tasks/211');
        $response->assertStatus(400);
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
        $response = $this->postJson('/tasks', [User::userId => "5b85495532736", Task::Title => "task4",
            Task::Description => "4th task", Task::Priority => 1, Task::Status => "pending"]);
        $response->assertStatus(400);
        $response->assertJson([AppConstants::Errors => array(User::userId => array("The selected user id is invalid."))]);
    }

    public function testTaskCreateFailureCaseInvalidTitle()
    {
        $user = User::find(1);
        $response = $this->postJson('/tasks', [User::userId => $user->user_id,
            Task::Description => "4th task", Task::Priority => 1, Task::Status => "pending"]);
        $response->assertStatus(400);
        $response->assertJson([AppConstants::Errors => array(Task::Title => array("The title field is required."))]);
    }

    public function testTaskCreateFailureCaseInvalidPriority()
    {
        $user = User::find(1);
        $response = $this->postJson('/tasks', [User::userId => $user->user_id, Task::Title => "task4",
            Task::Description => "4th task", Task::Priority => 11, Task::Status => "pending"]);
        $response->assertStatus(400);
        $response->assertJson([AppConstants::Errors => array(Task::Priority => array("The priority may not be greater than 10."))]);
    }

    public function testTaskCreateSuccessCase()
    {
        $user = User::find(1);
        $response = $this->postJson('/tasks', [User::userId => $user->user_id, Task::Title => "task4",
            Task::Description => "4th task", Task::Priority => 10, Task::Status => "pending"]);
        $response->assertStatus(200);
    }

    public function testForUserTasks()
    {
        $user = User::find(1);
        $response = $this->postJson('/tasks', [User::userId => $user->user_id, Task::Title => "task4",
            Task::Description => "4th task", Task::Priority => 10, Task::Status => "pending"]);
        $response->assertStatus(200);
        $response = $this->get("/users/$user->user_id/tasks");
        $response->assertStatus(200);
        $response->assertJson(["data" => [[User::userId => $user->user_id, Task::Title => "task4",
            Task::Description => "4th task", Task::Priority => 10, Task::Status => Task::PendingTaskStatus]]]);
    }


}
