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
use StartMeUp\Http\Requests\StoreMoodRequest;
use StartMeUp\Models\Mood;
use StartMeUp\Repositories\Eloquent\MoodsRepository;
use StartMeUp\Transformers\IdOnlyTransformer;
use StartMeUp\Transformers\GenericTransformer;
use Validator;

class UsersMoodsController extends Controller
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
        list($moods, $paginator) = $this->_getCollectionAndPaginator(new MoodsRepository($additionalInput));

        // Fractal
        $resource = new FractalResource\Collection($moods, new GenericTransformer());
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
        $moodData = $this->_getRequestData($request, 'mood');
        $rules = $this->_getValidationRules(new StoreMoodRequest());

        $validator = Validator::make($moodData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $mood = new Mood($moodData);
        if ($mood->save()) {
            $resource = new FractalResource\Item($mood, new IdOnlyTransformer());

            return response()
                ->json($this->_getResponseData($resource))
                ->setStatusCode(Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $userId
     * @param int $moodId
     *
     * @return Response
     */
    public function show($userId, $moodId)
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
        $moodsRepository = new MoodsRepository($additionalInput);
        $mood = $moodsRepository->find((int) $moodId);
        if (!$mood) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('Mood', $moodId))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        // Fractal
        $resource = new FractalResource\Item($mood, new GenericTransformer());

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $userId
     * @param int $moodId
     *
     * @return Response
     */
    public function update($userId, $moodId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $userId
     * @param int $moodId
     *
     * @return Response
     */
    public function destroy($userId, $moodId)
    {
        //
    }

    /**
     * @param int $userId
     *
     * @return Response
     */
    public function statistics($userId)
    {
        $moods = Mood::statistics($userId)->get();
        $resource = new FractalResource\Collection($moods, new GenericTransformer());

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
    }
}
