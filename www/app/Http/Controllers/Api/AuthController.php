<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Resource as FractalResource;
use StartMeUp\Http\Requests\LoginRequest;
use StartMeUp\Transformers\IdOnlyTransformer;
use Validator;

class AuthController extends Controller
{
    /**
     * Handle a login request to the API.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        // Validation through type hinting cannot be used here, because it is not a form post, but JSON data.
        $userData = $this->_getRequestData($request, 'user');
        $rules = $this->_getValidationRules(new LoginRequest());

        $validator = Validator::make($userData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $credentials = array_intersect_key($userData, ['name' => null, 'password' => null]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Fractal
            $resource = new FractalResource\Item($user, new IdOnlyTransformer());

            return response()
                ->json($this->_getResponseData($resource))
                ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()
                ->json($this->_getResponseDataMessageError('Cannot log in with given credentials.'))
                ->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }
    }
}
