<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Http\Response;

class ApiGoalsControllerTest extends ApiTestCase
{
    /**
     * @test
     * @covers Api\GoalsController::index()
     */
    public function it_should_fetch_all_goals()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('goals');
        $models = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertGreaterThan(0, count($models));
    }

    /**
     * @test
     * @covers Api\GoalsController::show()
     */
    public function it_should_fetch_a_single_goal()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('goals/1');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\GoalsController::show()
     */
    public function it_should_return_HTTP_NOT_FOUND_when_trying_to_fetch_non_existing_goal()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('goals/9999999');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\GoalsController::store()
     */
    public function it_should_create_a_new_goal_with_target_checkbox()
    {
        Session::start();
        // Arrange
        $parameters = [
            '_token' => csrf_token(),
        ];
        $content = [
            'goal' => [
                'name' => 'Test Goal TargetCheckbox',
                'notes' => 'Lorem ipsum',
                CreateCategoriesTable::FK => 1,
                CreateUsersTable::FK => 1,
                'target_class' => 'TargetCheckbox',
                'target' => [
                    'deadline_date' => '2015-06-16',
                    'deadline_time' => '13:14:15',
                ],
            ],
        ];

        // Act
        $response = $this->apiCallPOST('goals', $parameters, $content);

        // Assert
        $this->assertResponseStatus(Response::HTTP_CREATED);
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('data', $content);
        $this->assertObjectHasAttribute('id', $content->data);
    }

    /**
     * @test
     * @covers Api\GoalsController::store()
     */
    public function it_should_create_a_new_goal_with_target_recurring_checkbox()
    {
        Session::start();
        // Arrange
        $parameters = [
            '_token' => csrf_token(),
        ];
        $content = [
            'goal' => [
                'name' => 'Test Goal TargetRecurringCheckbox',
                'notes' => 'Lorem ipsum',
                CreateCategoriesTable::FK => 1,
                CreateUsersTable::FK => 1,
                'target_class' => 'TargetRecurringCheckbox',
                'target' => [
                    'deadline_date' => '2015-06-16',
                    'deadline_time' => '12:13:14',
                    'repeat_deadline' => 'WEEKLY',
                    'repeat_until_date' => '2016-06-16',
                    'repeat_until_time' => '12:13:14',
                ],
            ],
        ];

        // Act
        $response = $this->apiCallPOST('goals', $parameters, $content);

        // Assert
        $this->assertResponseStatus(Response::HTTP_CREATED);
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('data', $content);
        $this->assertObjectHasAttribute('id', $content->data);
    }

    /**
     * @test
     * @covers Api\GoalsController::store()
     */
    public function it_should_create_a_new_goal_with_target_duration()
    {
        Session::start();
        // Arrange
        $parameters = [
            '_token' => csrf_token(),
        ];
        $content = [
            'goal' => [
                'name' => 'Test Goal TargetDuration',
                'notes' => 'Lorem ipsum',
                CreateCategoriesTable::FK => 1,
                CreateUsersTable::FK => 1,
                'target_class' => 'TargetDuration',
                'target' => [
                    'time_estimated' => 10,
                    'time_increment' => 'HOUR',
                ],
            ],
        ];

        // Act
        $response = $this->apiCallPOST('goals', $parameters, $content);

        // Assert
        $this->assertResponseStatus(Response::HTTP_CREATED);
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('data', $content);
        $this->assertObjectHasAttribute('id', $content->data);
    }
}
