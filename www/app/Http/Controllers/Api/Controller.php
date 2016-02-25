<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use League\Fractal\Manager;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\Resource\ResourceInterface;
use StartMeUp\Http\Controllers\Controller as BaseController;
use StartMeUp\Http\Requests\Request as BaseRequest;
use StartMeUp\Repositories\Eloquent\Repository;

abstract class Controller extends BaseController
{
    const API_RESULT_LIMIT_DEFAULT = 10;
    const API_RESULT_LIMIT_MAX = 100;

    /**
     * @var Manager
     */
    protected $fractal;

    /**
     * Constructor.
     *
     * @param Manager            $fractalManager
     * @param SerializerAbstract $fractalSerializer
     */
    public function __construct(Manager $fractalManager, SerializerAbstract $fractalSerializer)
    {
        $this->fractal = $fractalManager;
        $this->fractal->setSerializer($fractalSerializer);
    }

    /**
     * @param Repository $repository
     *
     * @return array
     */
    protected function _getCollectionAndPaginator(Repository $repository)
    {
        return [
            $repository->getCollection(),
            $repository->getPaginator(),
        ];
    }

    /**
     * @param Request $request
     * @param string  $entity
     *
     * @return mixed
     */
    protected function _getRequestData(Request $request, $entity = '')
    {
        $array = json_decode($request->getContent(), true);

        return empty($entity) ? $array : $array[$entity];
    }

    /**
     * @param ResourceInterface $resource
     *
     * @return array
     */
    protected function _getResponseData(ResourceInterface $resource)
    {
        return $this->fractal->createData($resource)->toArray();
    }

    /**
     * @param string $message
     *
     * @return array
     */
    protected function _getResponseDataMessageError($message)
    {
        return [
            'errors' => [
                ['message' => $message],
            ],
        ];
    }

    /**
     * @param string $entity
     * @param int    $id
     *
     * @return array
     */
    protected function _getResponseDataMessageEntityDoesNotExistError($entity, $id)
    {
        return [
            'errors' => [
                ['message' => "${entity} with ID '${id}' does not exist."],
            ],
        ];
    }

    /**
     * @param Validator $validator
     *
     * @return array
     */
    protected function _getResponseDataValidatorError(Validator $validator)
    {
        return [
            'errors' => $validator->errors()->all(),
        ];
    }

    /**
     * @param BaseRequest $request
     *
     * @return mixed
     */
    protected function _getValidationRules(BaseRequest $request)
    {
        return $request->rules();
    }
}
