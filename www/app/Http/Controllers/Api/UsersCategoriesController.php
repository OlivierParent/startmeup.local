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
use StartMeUp\Repositories\Eloquent\CategoriesRepository;
use StartMeUp\Transformers\GenericTransformer;

class UsersCategoriesController extends Controller
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
        list($categories, $paginator) = $this->_getCollectionAndPaginator(new CategoriesRepository($additionalInput));

        // Fractal
        $resource = new FractalResource\Collection($categories, new GenericTransformer());
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $userId
     * @param int $categoryId
     *
     * @return Response
     */
    public function show($userId, $categoryId)
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
        $categoriesRepository = new CategoriesRepository($additionalInput);
        $category = $categoriesRepository->find((int) $categoryId);
        if (!$category) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('Category', $categoryId))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        // Fractal
        $resource = new FractalResource\Item($category, new GenericTransformer());

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $userId
     * @param int $categoryId
     *
     * @return Response
     */
    public function update($userId, $categoryId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $userId
     * @param int $categoryId
     *
     * @return Response
     */
    public function destroy($userId, $categoryId)
    {
        //
    }
}
