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
use StartMeUp\Http\Requests\StoreTargetCheckboxRequest;
use StartMeUp\Http\Requests\StoreTargetDurationRequest;
use StartMeUp\Http\Requests\StoreTargetRecurringCheckboxRequest;
use StartMeUp\Http\Requests\UpdateGoalRequest;
use StartMeUp\Models\Category;
use StartMeUp\Models\Goal;
use StartMeUp\Models\TargetCheckbox;
use StartMeUp\Models\TargetDuration;
use StartMeUp\Models\TargetRecurringCheckbox;
use StartMeUp\Repositories\Eloquent\GoalsRepository;
use StartMeUp\Transformers\IdOnlyTransformer;
use StartMeUp\Transformers\GenericTransformer;
use StartMeUp\User;
use Validator;

class GoalsController extends Controller
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
        list($goals, $paginator) = $this->_getCollectionAndPaginator(new GoalsRepository());

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

        $categoryId = (int) $goalData['category_id'];
        $userId = (int) $goalData['user_id'];
        $targetClass = $goalData['target_class'];

        $category = Category::find($categoryId);
        $user = User::find($userId);

        switch ($targetClass) {
            case 'TargetCheckbox':
                $storeTargetCheckboxRequest = new StoreTargetCheckboxRequest();
                $rules = $storeTargetCheckboxRequest->rules();
                $validator = Validator::make($goalData['target'], $rules);
                if ($validator->fails()) {
                    return response()
                        ->json($this->_getResponseDataValidatorError($validator))
                        ->setStatusCode(Response::HTTP_BAD_REQUEST);
                }
                $target = new TargetCheckbox($goalData['target']);
                $target->save();
                $goal->target()->associate($target);
                break;
            case 'TargetRecurringCheckbox':
                $storeTargetRecurringCheckboxRequest = new StoreTargetRecurringCheckboxRequest();
                $rules = $storeTargetRecurringCheckboxRequest->rules();
                $validator = Validator::make($goalData['target'], $rules);
                if ($validator->fails()) {
                    return response()
                        ->json($this->_getResponseDataValidatorError($validator))
                        ->setStatusCode(Response::HTTP_BAD_REQUEST);
                }
                $target = new TargetRecurringCheckbox($goalData['target']);
                $target->save();
                $goal->target()->associate($target);
                break;
            case 'TargetDuration':
                $storeTargetDurationRequest = new StoreTargetDurationRequest();
                $rules = $storeTargetDurationRequest->rules();
                $validator = Validator::make($goalData['target'], $rules);
                if ($validator->fails()) {
                    return response()
                        ->json($this->_getResponseDataValidatorError($validator))
                        ->setStatusCode(Response::HTTP_BAD_REQUEST);
                }
                $target = new TargetDuration($goalData['target']);
                $target->save();
                $goal->target()->associate($target);
                break;
            default:
                break;
        }

        $goal->user()->associate($user);
        $goal->category()->associate($category);

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
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $goalsRepository = new GoalsRepository();
        $goal = $goalsRepository->find((int) $id);

        if (!$goal) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('Goal', $id))
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
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // Validation through type hinting cannot be used here, because it is not a form post, but JSON data.
        $goalData = $this->_getRequestData($request, 'goal');
        $rules = $this->_getValidationRules(new UpdateGoalRequest());

        $validator = Validator::make($goalData, $rules);
        if ($validator->fails()) {
            return response()
                ->json($this->_getResponseDataValidatorError($validator))
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $goalsRepository = new GoalsRepository();
        $goal = $goalsRepository->find($id);
        if (!$goal) {
            return response()
                ->json($this->_getResponseDataMessageEntityDoesNotExistError('Goal', $id))
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        $goal->fill($goalData); // Update User model's data.
        $goal->save(); // Persist User model.

        // Fractal
        $resource = new FractalResource\Item($goal, new GenericTransformer());

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
