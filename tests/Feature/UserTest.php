<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 29/08/18
 * Time: 12:36 PM
 */

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Client;
use App\Constants\AppConstants;
use App\Constants\ErrorMessages;
use App\Constants\TasksConstants;
use App\Constants\UsersConstants;


class UserTest extends TestCase
{
    private $client ;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Client(['base_uri' => 'http://localhost:8000/']);
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function testUserGetByIdSuccessCase()
    {
        $response = $this->get("/user/1");
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUserGetSuccessCase()
    {
        $response = $this->get("/user");
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUserGetByIdForFailureCase()
    {
        $response = $this->get('/user/211');
        $response->assertStatus(404);
    }

    public function testUserDeleteCaseForSuccessCase()
    {
        $response = $this->delete('/user/1');
        $response->assertStatus(200);
    }

    public function testUserDeleteCaseForFailureCase()
    {
        $response = $this->delete('/user/211');
        $response->assertStatus(404);
    }

    public function testUserCreateForFailureCase()
    {
        $response = $this->postJson('/user', []);
        $response->assertStatus(400);

    }

    public function testUserCreateForFailureCaseInvalidEmail()
    {

        $response = $this->postJson('/user', [UsersConstants::name => "pankaj", UsersConstants::email => "abcd"]);
        $response->assertStatus(400);
        $response->assertJson([TasksConstants::Status => AppConstants::Failure, AppConstants::Error => ErrorMessages::INVALID_USER_EMAIL]);
    }

    public function testUserCreateForFailureCaseInvalidPhoneNumber()
    {
        $response = $this->postJson('/user', [UsersConstants::name => "pankaj", UsersConstants::email => "pankaj@razorpay.com"]);
        $response->assertStatus(400);
        $response->assertJson([TasksConstants::Status => AppConstants::Failure, AppConstants::Error => ErrorMessages::INVALID_PHONE_NUMBER]);
    }

    public function testUserCreationForSuccessCase()
    {
        $response = $this->postJson("/user", [UsersConstants::name => "pankaj kumar",
            UsersConstants::email => "pankaj.kumar@razorpay.com", UsersConstants::phone => 9000000000]);
        $response->assertStatus(200);
        $response->assertJson([UsersConstants::name => "pankaj kumar", UsersConstants::email => "pankaj.kumar@razorpay.com", UsersConstants::phone => 9000000000]);
    }

}
