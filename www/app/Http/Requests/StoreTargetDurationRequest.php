<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Http\Requests;

use StartMeUp\Models\TargetDuration;

class StoreTargetDurationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'time_estimated' => 'required',
            'time_increment' => 'required|in:'.implode(',', TargetDuration::TIME_INCREMENTS),
        ];
    }
}
