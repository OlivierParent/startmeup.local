<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Database\Eloquent\Model;

class IdOnlyTransformer extends TransformerAbstract
{
    /**
     * @param Model $model
     *
     * @return array
     */
    public function transform(Model $model)
    {
        return [
            'id' => $model->id,
        ];
    }
}
