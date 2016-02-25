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
use StartMeUp\Contracts\Repositories\AddressesContract;
use StartMeUp\Contracts\Repositories\LocalitiesContract;
use StartMeUp\Http\Requests\StoreAddressRequest;
use StartMeUp\Models\Address;
use StartMeUp\Transformers\IdOnlyTransformer;
use StartMeUp\Transformers\GenericTransformer;
use Validator;

class AddressesController extends Controller
{
    /**
     * @var AddressesContract
     */
    protected $addressRepository;

    /**
     * @var SerializerAbstract
     */
    protected $localityRepository;

    /**
     * Constructor.
     *
     * @param Manager            $fractalManager
     * @param SerializerAbstract $fractalSerializer
     * @param AddressesContract  $addressesRepository
     * @param LocalitiesContract $localitiesRepository
     */
    public function __construct(Manager $fractalManager, SerializerAbstract $fractalSerializer, AddressesContract $addressesRepository, LocalitiesContract $localitiesRepository)
    {
        parent::__construct($fractalManager, $fractalSerializer);
        $this->addressesRepository = $addressesRepository;
        $this->localitiesRepository = $localitiesRepository;
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
        list($addresses, $paginator) = $this->_getCollectionAndPaginator($this->addressesRepository);

        // Fractal
        $resource = new FractalResource\Collection($addresses, new GenericTransformer());
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
     * @return mixed
     */
    public function store(Request $request)
    {
        // Validation through type hinting cannot be used here, because it is not a form post, but JSON data.
        $addressData = $this->_getRequestData($request, 'address');
        $rules = $this->_getValidationRules(new StoreAddressRequest());

        $validator = Validator::make($addressData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $locality = $this->localitiesRepository->find($addressData['locality_id']);

        $address = new Address($addressData);
        $address->locality()->associate($locality);

        if ($address->save()) {
            $resource = new FractalResource\Item($address, new IdOnlyTransformer());

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
        //
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
