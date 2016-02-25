<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Http\Response;

class ApiTargetsCheckboxControllerTest extends ApiTestCase
{
    /**
     * @test
     * @covers Api\TargetsCheckboxController::index()
     */
    public function it_should_fetch_all_targets_checkbox()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('targets/checkbox');
        $models = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertGreaterThan(0, count($models));
    }

    /**
     * @test
     * @covers Api\TargetsCheckboxController::show()
     */
    public function it_should_fetch_a_single_target_checkbox()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('targets/checkbox/1');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\TargetsCheckboxController::update()
     */
    public function it_should_update_a_target_checkbox()
    {
        Session::start();
        // Arrange
        $parameters = [
            '_token' => csrf_token(),
        ];
        $content = [
            'target' => [
                'achieved_at' => '2015-06-16 12:13:14',
            ],
        ];

        // Act
        $response = $this->apiCallPUT('targets/checkbox/1', $parameters, $content);

        // Assert
        $this->assertResponseStatus(Response::HTTP_NO_CONTENT);
    }
}
