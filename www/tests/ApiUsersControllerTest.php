<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Http\Response;

class ApiUsersControllerTest extends ApiTestCase
{
    /**
     * @test
     * @covers Api\UserController::index()
     */
    public function it_should_fetch_all_users()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('users');
        $models = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertGreaterThan(0, count($models));
    }

    /**
     * @test
     * @covers Api\UserController::show()
     */
    public function it_should_fetch_a_single_user()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('users/1');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\UserController::show()
     */
    public function it_should_return_HTTP_NOT_FOUND_when_trying_to_fetch_non_existing_user()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('users/9999999');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\UserController::store()
     */
    public function it_should_create_a_new_user()
    {
        Session::start();
        // Arrange
        $parameters = [
            '_token' => csrf_token(),
        ];

        $random_number = mt_rand();

        $content = [
            'user' => [
                'email' => "smu_user_${random_number}@arteveldehs.be",
                'name' => "smu_user_${random_number}",
                'password' => 'smu_password',
                'given_name' => 'Start',
                'family_name' => 'Me Up',
                'birthday' => '1977-06-16',
                'interests' => [
                    ['id' => 10],
                    ['name' => "test_interest_${random_number}"],
                ],
            ],
        ];

        // Act
        $response = $this->apiCallPOST('users', $parameters, $content);

        // Assert
        $this->assertResponseStatus(Response::HTTP_CREATED);
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('data', $content);
        $this->assertObjectHasAttribute('id', $content->data);
        $this->assertObjectHasAttribute('settings_id', $content->data);
    }
}
