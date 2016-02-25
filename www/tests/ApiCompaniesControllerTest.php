<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Http\Response;

class ApiCompaniesControllerTest extends ApiTestCase
{
    /**
     * @test
     * @covers Api\CompaniesController::index()
     */
    public function it_should_fetch_all_companies()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('companies');
        $models = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertGreaterThan(0, count($models));
    }

    /**
     * @test
     * @covers Api\CompaniesController::show()
     */
    public function it_should_fetch_a_single_company()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('companies/1');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\CompaniesController::show()
     */
    public function it_should_return_HTTP_NOT_FOUND_when_trying_to_fetch_non_existing_company()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('companies/9999999');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\CompaniesController::store()
     */
    public function it_should_create_a_new_company()
    {
        Session::start();
        // Arrange
        $parameters = [
            '_token' => csrf_token(),
        ];
        $content = [
            'company' => [
                'address_id' => 1,
                'name' => 'smu_company_'.mt_rand(),
                'description' => 'Lorem ipsum',
            ],
        ];

        // Act
        $response = $this->apiCallPOST('companies', $parameters, $content);

        // Assert
        $this->assertResponseStatus(Response::HTTP_CREATED);
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('data', $content);
        $this->assertObjectHasAttribute('id', $content->data);
    }
}
