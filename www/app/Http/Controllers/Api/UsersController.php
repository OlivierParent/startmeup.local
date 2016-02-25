<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Http\Controllers\Api;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Pagination\IlluminatePaginatorAdapter as FractalPaginatorAdapter;
use League\Fractal\Resource as FractalResource;
use StartMeUp\Jobs\AddDefaultGoalsForNewUserJob;
use StartMeUp\Jobs\AddSettingsForNewUserJob;
use StartMeUp\Jobs\SaveUserInterestsJob;
use StartMeUp\Http\Requests\StoreUserRequest;
use StartMeUp\Http\Requests\UpdateUserRequest;
use StartMeUp\Repositories\Eloquent\CompaniesRepository;
use StartMeUp\Repositories\Eloquent\UsersRepository;
use StartMeUp\Transformers\GenericTransformer;
use StartMeUp\Transformers\NewUserTransformer;
use StartMeUp\User;
use Validator;

class UsersController extends Controller
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
        list($users, $paginator) = $this->_getCollectionAndPaginator(new UsersRepository());

        // Fractal
        $resource = new FractalResource\Collection($users, new GenericTransformer());
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
        $userData = $this->_getRequestData($request, 'user');
        $rules = $this->_getValidationRules(new StoreUserRequest());

        $validator = Validator::make($userData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $user = new User($userData);
        $user->password = Hash::make($userData['password']);
        if ($user->save()) {
            $user->settings_id = $this->dispatch(new AddSettingsForNewUserJob($user));
            $this->dispatch(new AddDefaultGoalsForNewUserJob($user));
            if (is_array($userData['interests'])) {
                $this->dispatch(new SaveUserInterestsJob($user, $userData['interests']));
            }
            $resource = new FractalResource\Item($user, new NewUserTransformer());

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
        $usersRepository = new UsersRepository();
        $user = $usersRepository->find($id);
        if (!$user) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('User', $id))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        // Fractal
        $resource = new FractalResource\Item($user, new GenericTransformer());

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
        $userData = $this->_getRequestData($request);
        $rules = $this->_getValidationRules(new UpdateUserRequest());

        $validator = Validator::make($userData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $usersRepository = new UsersRepository();
        $user = $usersRepository->find($id);
        if (!$user) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('User', $id))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $user->fill($userData); // Update User model's data.

        if (isset($userData['company_id'])) {
            $companiesRepository = new CompaniesRepository();
            $company = $companiesRepository->find($userData['company_id']);
            if ($company) {
                $user->company()->associate($company);
            }
        }

        $user->save(); // Persist User model.

        // Fractal
        $resource = new FractalResource\Item($user, new GenericTransformer());

        return response()
            ->json($this->_getResponseData($resource))
            ->setStatusCode(Response::HTTP_OK);
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
