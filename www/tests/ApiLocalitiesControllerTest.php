<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Http\Response;
use StartMeUp\Models\Locality;
use StartMeUp\Models\Region;

class ApiLocalitiesControllerTest extends ApiTestCase
{
    /**
     * @test
     * @covers Api\LocalitiesController::index()
     */
    public function it_should_fetch_all_localities()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('localities');
        $models = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertGreaterThan(0, count($models));
    }

    /**
     * @test
     * @covers Api\LocalitiesController::show()
     */
    public function it_should_fetch_a_single_locality()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('localities/1');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseOk();
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\LocalitiesController::show()
     */
    public function it_should_return_HTTP_NOT_FOUND_when_trying_to_fetch_non_existing_locality()
    {
        // Arrange
        // $ ./artisan migrate --seed

        // Act
        $response = $this->apiCallGET('localities/9999999');
        $model = json_decode($response->getContent());

        // Assert
        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
        $this->assertInternalType('object', $model);
    }

    /**
     * @test
     * @covers Api\LocalitiesController::store()
     */
    public function it_should_create_a_new_locality()
    {
        Session::start();
        // Arrange
        $parameters = [
            '_token' => csrf_token(),
        ];

        $region = Region::find(1);

        $locality = factory(Locality::class)->make([
            'region_id' => $region->id,
        ]);

        $content = [
            'locality' => $locality,
        ];

        // Act
        $response = $this->apiCallPOST('localities', $parameters, $content);

        // Assert
        $this->assertResponseStatus(Response::HTTP_CREATED);
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('data', $content);
        $this->assertObjectHasAttribute('id', $content->data);
    }
}
