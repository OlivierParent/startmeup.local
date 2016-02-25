<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Pagination\IlluminatePaginatorAdapter as FractalPaginatorAdapter;
use League\Fractal\Resource as FractalResource;
use StartMeUp\Http\Requests\StoreCompanyRequest;
use StartMeUp\Models\Company;
use StartMeUp\Transformers\IdOnlyTransformer;
use StartMeUp\Transformers\GenericTransformer;
use StartMeUp\Repositories\Eloquent\AddressesRepository;
use StartMeUp\Repositories\Eloquent\CompaniesRepository;
use Validator;

class CompaniesController extends Controller
{
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
        list($companies, $paginator) = $this->_getCollectionAndPaginator(new CompaniesRepository());

        // Fractal
        $resource = new FractalResource\Collection($companies, new GenericTransformer());
        $resource->setPaginator(new FractalPaginatorAdapter($paginator));

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Validation through type hinting cannot be used here, because it is not a form post, but JSON data.
        $companyData = $this->_getRequestData($request, 'company');
        $rules = $this->_getValidationRules(new StoreCompanyRequest());

        $validator = Validator::make($companyData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $addressesRepository = new AddressesRepository();
        $address = $addressesRepository->find($companyData['address_id']);

        $company = new Company($companyData);
        $company->address()->associate($address);

        if ($company->save()) {
            $resource = new FractalResource\Item($company, new IdOnlyTransformer());

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
        $company = Company::find($id);

        if (!$company) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('Company', $id))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        $resource = new FractalResource\Item($company, new GenericTransformer());

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
