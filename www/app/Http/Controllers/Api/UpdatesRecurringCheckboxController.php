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
use StartMeUp\Http\Requests\StoreUpdateRecurringCheckboxRequest;
use StartMeUp\Http\Requests\UpdateUpdateRecurringCheckboxRequest;
use StartMeUp\Models\UpdateRecurringCheckbox;
use StartMeUp\Repositories\Eloquent\UpdatesRecurringCheckboxRepository;
use StartMeUp\Transformers\GenericTransformer;
use StartMeUp\Transformers\IdOnlyTransformer;
use Validator;

class UpdatesRecurringCheckboxController extends Controller
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
        list($updates, $paginator) = $this->_getCollectionAndPaginator(new UpdatesRecurringCheckboxRepository());

        // Fractal
        $resource = new FractalResource\Collection($updates, new GenericTransformer());
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
        $updateData = $this->_getRequestData($request, 'update');
        $rules = $this->_getValidationRules(new StoreUpdateRecurringCheckboxRequest());

        $validator = Validator::make($updateData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $update = new UpdateRecurringCheckbox($updateData);
        if ($update->save()) {
            $resource = new FractalResource\Item($update, new IdOnlyTransformer());

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
        $updatesRepository = new UpdatesRecurringCheckboxRepository();
        $update = $updatesRepository->find($id);
        if (!$update) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('UpdateRecurringCheckbox', $id))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        // Fractal
        $resource = new FractalResource\Item($update, new GenericTransformer());

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
        $updateData = $this->_getRequestData($request, 'update');
        $rules = $this->_getValidationRules(new UpdateUpdateRecurringCheckboxRequest());

        $validator = Validator::make($updateData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $updatesRepository = new UpdatesRecurringCheckboxRepository();
        $update = $updatesRepository->find($id);
        if (!$update) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('UpdateRecurringCheckbox', $id))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $update->fill($updateData);
        $update->save();

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
