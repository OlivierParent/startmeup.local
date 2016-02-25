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
use StartMeUp\Http\Requests\StoreGoalRequest;
use StartMeUp\Models\Goal;
use StartMeUp\Repositories\Eloquent\GoalsRepository;
use StartMeUp\Transformers\IdOnlyTransformer;
use StartMeUp\Transformers\GenericTransformer;
use Validator;

class UsersGoalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $userId
     *
     * @return Response
     */
    public function index($userId)
    {
        /*
         * filter[attribute]
         * limit=100
         * sort[attribute]=desc
         * include[]=property_name
         */

        // Laravel Eloquent
        $additionalInput = [
            'filter' => [
                'users' => (int) $userId,
            ],
        ];
        list($goals, $paginator) = $this->_getCollectionAndPaginator(new GoalsRepository($additionalInput));

        // Fractal
        $resource = new FractalResource\Collection($goals, new GenericTransformer());
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
        $goalData = $this->_getRequestData($request, 'goal');
        $rules = $this->_getValidationRules(new StoreGoalRequest());

        $validator = Validator::make($goalData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $goal = new Goal($goalData);
        if ($goal->save()) {
            $resource = new FractalResource\Item($goal, new IdOnlyTransformer());

            return response()
                ->json($this->_getResponseData($resource))
                ->setStatusCode(Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $userId
     * @param int $goalId
     *
     * @return Response
     */
    public function show($userId, $goalId)
    {
        /*
         * filter[attribute]
         * include[table_name]
         */

        // Laravel Eloquent
        $additionalInput = [
            'filter' => [
                'users' => (int) $userId,
            ],
        ];
        $goalsRepository = new GoalsRepository($additionalInput);
        $goal = $goalsRepository->find((int) $goalId);
        if (!$goal) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('Goal', $goalId))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        // Fractal
        $resource = new FractalResource\Item($goal, new GenericTransformer());

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $userId
     * @param int $goalId
     *
     * @return Response
     */
    public function update($userId, $goalId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $userId
     * @param int $goalId
     *
     * @return Response
     */
    public function destroy($userId, $goalId)
    {
        //
    }
}
