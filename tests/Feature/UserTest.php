<?php
/**
 * Created by PhpStorm.
 * User: pankajkumar
 * Date: 29/08/18
 * Time: 12:36 PM
 */

namespace Tests\Feature;


use App\Models\Task;
use App\Models\User;
use Tests\TestCase;
use App\Constants\AppConstants;
use App\Constants\ErrorMessages;


class UserTest extends TestCase
{
    private $client ;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function testUserGetByIdSuccessCase()
    {
        $response = $this->get("/users/1");
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUserGetSuccessCase()
    {
        $response = $this->get("/users");
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUserGetByIdForFailureCase()
    {
        $response = $this->get('/users/211');
        $response->assertStatus(400);
    }

    public function testUserDeleteCaseForSuccessCase()
    {
        $response = $this->delete('/users/1');
        $response->assertStatus(204);
    }

    public function testUserDeleteCaseForFailureCase()
    {
        $response = $this->delete('/users/211');
        $response->assertStatus(400);
    }

    public function testUserCreateForFailureCase()
    {
        $response = $this->postJson('/users', []);
        $response->assertStatus(400);

    }

    public function testUserCreateForFailureCaseInvalidEmail()
    {

        $response = $this->postJson('/users', [User::name => "pankaj", User::email => "abcd", User::phone => 9000000000]);
        $response->assertStatus(400);
        $response->assertJson([AppConstants::Errors => array(User::email => array("The email format is invalid."))]);
    }

    public function testUserCreateForFailureCaseInvalidPhoneNumber()
    {
        $response = $this->postJson('/users', [User::name => "pankaj", User::email => "pankaj@razorpay.com"]);
        $response->assertStatus(400);
        $response->assertJson([AppConstants::Errors => array(User::phone => array("The phone field is required."))]);
    }

    public function testUserCreationForSuccessCase()
    {
        $response = $this->postJson("/users", [User::name => "pankaj kumar",
            User::email => "pankajkumar@razorpay.com", User::phone => 9000000000]);
        $response->assertStatus(200);
        // @Todo debug this response formet
        //$response->assertJson([User::name => "pankaj kumar", User::email => "pankaj.kumar@razorpay.com", User::phone => 9000000000]);
    }

}
