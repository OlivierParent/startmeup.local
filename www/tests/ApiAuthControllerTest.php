<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Http\Response;

class ApiAuthControllerTest extends ApiTestCase
{
    /**
     * @test
     * @covers Api\AuthController::login()
     */
    public function it_should_return_the_id_of_an_existing_user()
    {
        Session::start();
        // Arrange
        $parameters = [
            '_token' => csrf_token(),
        ];

        $content = [
            'user' => [
                'name' => 'smu_user',
                'password' => 'smu_password',
            ],
        ];

        // Act
        $response = $this->apiCallPOST('auth', $parameters, $content);

        // Assert
        $this->assertResponseStatus(Response::HTTP_OK);
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('data', $content);
        $this->assertObjectHasAttribute('id', $content->data);
    }

    /**
     * @test
     * @covers Api\AuthController::login()
     */
    public function it_should_return_errors_when_a_non_existing_user_tries_to_login()
    {
        Session::start();
        // Arrange
        $parameters = [
            '_token' => csrf_token(),
        ];

        $content = [
            'user' => [
                'name' => '?',
                'password' => '?',
            ],
        ];

        // Act
        $response = $this->apiCallPOST('auth', $parameters, $content);

        // Assert
        $this->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('errors', $content);
    }
}
