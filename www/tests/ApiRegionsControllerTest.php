<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Http\Response;
use StartMeUp\Models\Country;
use StartMeUp\Models\Region;

class ApiRegionsControllerTest extends ApiTestCase
{
    /**
     * @test
     * @covers Api\RegionsController::index()
     */
    public function it_should_fetch_all_regions()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('regions');
        $models = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertGreaterThan(0, count($models));
    }

    /**
     * @test
     * @covers Api\RegionsController::show()
     */
    public function it_should_fetch_a_single_region()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('regions/1');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\RegionsController::show()
     */
    public function it_should_return_HTTP_NOT_FOUND_when_trying_to_fetch_non_existing_region()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('regions/9999999');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\RegionsController::store()
     */
    public function it_should_create_a_new_region()
    {
        Session::start();
        // Arrange
        $parameters = [
            '_token' => csrf_token(),
        ];

        $country = Country::find(1);

        $region = factory(Region::class)->make([
            'country_id' => $country->id,
        ]);

        $content = [
            'region' => $region,
        ];

        // Act
        $response = $this->apiCallPOST('regions', $parameters, $content);

        // Assert
        $this->assertResponseStatus(Response::HTTP_CREATED);
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('data', $content);
        $this->assertObjectHasAttribute('id', $content->data);
    }
}
