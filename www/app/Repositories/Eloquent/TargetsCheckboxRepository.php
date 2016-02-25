<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use StartMeUp\Contracts\Repositories\TargetsCheckboxContract;
use StartMeUp\Models\TargetCheckbox;

class TargetsCheckboxRepository extends Repository implements TargetsCheckboxContract
{
    protected $filtersValid = [];

    protected $includesValid = [];

    protected $sortsValid = [
        'id',
    ];

    /**
     * @param array $additionalInput
     */
    public function __construct(array $additionalInput = [])
    {
        $this->model = new TargetCheckbox();
        $this->query = $this->model->query();
        parent::__construct($additionalInput);
    }

    public function applyFilters()
    {
        //
    }
}
