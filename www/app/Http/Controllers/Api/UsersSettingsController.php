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
use StartMeUp\Http\Requests\StoreSettingsRequest;
use StartMeUp\Http\Requests\UpdateSettingsRequest;
use StartMeUp\Models\Settings;
use StartMeUp\Repositories\Eloquent\SettingsRepository;
use StartMeUp\Repositories\Eloquent\UsersRepository;
use StartMeUp\Transformers\IdOnlyTransformer;
use StartMeUp\Transformers\GenericTransformer;
use Validator;

class UsersSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $userId
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
        list($settings, $paginator) = $this->_getCollectionAndPaginator(new SettingsRepository($additionalInput));

        // Fractal
        $resource = new FractalResource\Collection($settings, new GenericTransformer());
        $resource->setPaginator(new FractalPaginatorAdapter($paginator));

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $userId
     *
     * @return Response
     */
    public function store(Request $request, $userId)
    {
        // Validation through type hinting cannot be used here, because it is not a form post, but JSON data.
        $settingsData = $this->_getRequestData($request, 'settings');
        $rules = $this->_getValidationRules(new StoreSettingsRequest());

        $validator = Validator::make($settingsData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $usersRepository = new UsersRepository();
        $user = $usersRepository->find($userId);
        if (!$user) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('User', $userId))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        $settings = new Settings($settingsData);
        $settings->user()->associate($user);
        if ($settings->save()) {
            $resource = new FractalResource\Item($settings, new IdOnlyTransformer());

            return response()
                ->json($this->_getResponseData($resource))
                ->setStatusCode(Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $userId
     * @param int $settingsId
     *
     * @return Response
     */
    public function show($userId, $settingsId)
    {
        // Laravel Eloquent
        $usersRepository = new UsersRepository();
        $user = $usersRepository->find($userId);
        if (!$user) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('User', $userId))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        $settingsRepository = new SettingsRepository();
        $settings = $settingsRepository->find($settingsId);
        if (!$settings) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('Settings', $settingsId))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        // Fractal
        $resource = new FractalResource\Item($settings, new GenericTransformer());

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $userId
     * @param int     $settingsId
     *
     * @return Response
     */
    public function update(Request $request, $userId, $settingsId)
    {
        // Validation through type hinting cannot be used here, because it is not a form post, but JSON data.
        $settingsData = $this->_getRequestData($request);
        $rules = $this->_getValidationRules(new UpdateSettingsRequest());

        $validator = Validator::make($settingsData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $usersRepository = new UsersRepository();
        $user = $usersRepository->find($userId);
        if (!$user) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('User', $userId))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        $settingsRepository = new SettingsRepository();
        $settings = $settingsRepository->find($settingsId);
        if (!$settings) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('Settings', $settingsId))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $settings->fill($settingsData); // Update Settings model's data.
        $settings->save(); // Persist Settings model.
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $userId
     * @param int $settingsId
     *
     * @return Response
     */
    public function destroy($userId, $settingsId)
    {
        //
    }
}
