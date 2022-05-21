<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function testRequiredFieldsForLogin()
    {
        $this->json("POST", "api/login", [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."]
                ]
            ]);
    }

    public function testFailedLogin()
    {
        $loginData = ["email" => "abc@abc.com", "password" => "abc123"];

        $this->json("POST", "api/login", $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "email" => "Invalid email or password."
            ]);
    }

    public function testSuccessfulLogin()
    {
        $loginData = ["email" => "rtorp@example.org", "password" => "password"];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "results"
            ]);

        $this->assertAuthenticated();
    }
}
