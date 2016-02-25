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
use StartMeUp\Http\Requests\UpdateTargetDurationRequest;
use StartMeUp\Repositories\Eloquent\TargetsDurationRepository;
use StartMeUp\Transformers\GenericTransformer;
use Validator;

class TargetsDurationController extends Controller
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
        list($targets, $paginator) = $this->_getCollectionAndPaginator(new TargetsDurationRepository());

        // Fractal
        $resource = new FractalResource\Collection($targets, new GenericTransformer());
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
        //
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
        $targetsRepository = new TargetsDurationRepository();
        $target = $targetsRepository->find($id);
        if (!$target) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('TargetDuration', $id))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        // Fractal
        $resource = new FractalResource\Item($target, new GenericTransformer());

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // Validation through type hinting cannot be used here, because it is not a form post, but JSON data.
        $targetData = $this->_getRequestData($request, 'target');
        $rules = $this->_getValidationRules(new UpdateTargetDurationRequest());

        $validator = Validator::make($targetData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $targetsRepository = new TargetsDurationRepository();
        $target = $targetsRepository->find($id);
        if (!$target) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('TargetRecurringCheckbox', $id))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $target->fill($targetData);
        $target->save();

        return response()
            ->json()
            ->setStatusCode(Response::HTTP_NO_CONTENT);
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
