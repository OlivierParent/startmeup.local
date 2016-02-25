<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter as FractalPaginatorAdapter;
use League\Fractal\Resource as FractalResource;
use League\Fractal\Serializer\SerializerAbstract;
use StartMeUp\Contracts\Repositories\CountriesContract;
use StartMeUp\Http\Requests\StoreCountryRequest;
use StartMeUp\Models\Country;
use StartMeUp\Transformers\GenericTransformer;
use StartMeUp\Transformers\IdOnlyTransformer;
use Validator;

class CountriesController extends Controller
{
    protected $countriesRepository;

    /**
     * Constructor.
     *
     * @param Manager            $fractalManager
     * @param SerializerAbstract $fractalSerializer
     * @param CountriesContract  $countriesRepository
     */
    public function __construct(Manager $fractalManager, SerializerAbstract $fractalSerializer, CountriesContract $countriesRepository)
    {
        parent::__construct($fractalManager, $fractalSerializer);
        $this->countriesRepository = $countriesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /*
         * filter[attribute]
         * limit=100
         * sort[attribute]=desc
         * include[]=property_name
         */

        // Laravel Eloquent
        list($countries, $paginator) = $this->_getCollectionAndPaginator($this->countriesRepository);

        // Fractal
        $resource = new FractalResource\Collection($countries, new GenericTransformer());
        $resource->setPaginator(new FractalPaginatorAdapter($paginator));

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Validation through type hinting cannot be used here, because it is not a form post, but JSON data.
        $countryData = $this->_getRequestData($request, 'country');
        $rules = $this->_getValidationRules(new StoreCountryRequest());

        $validator = Validator::make($countryData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $country = new Country($countryData);
        $country->iso = 'XX'; // ISO 3166-1 Alpha-2 cannot easily be determined based upon User entered data.
        $country->name = ucwords($country->name); // @todo Add mutator to model?
        if ($country->save()) {
            $resource = new FractalResource\Item($country, new IdOnlyTransformer());

            return response()
                ->json($this->_getResponseData($resource))
                ->setStatusCode(Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        // Laravel Eloquent
        $country = $this->countriesRepository->find($id);
        if (!$country) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('Country', $id))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        // Fractal
        $resource = new FractalResource\Item($country, new GenericTransformer());

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
