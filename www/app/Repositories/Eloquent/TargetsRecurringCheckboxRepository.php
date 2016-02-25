<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use StartMeUp\Contracts\Repositories\TargetsRecurringCheckboxContract;
use StartMeUp\Models\TargetRecurringCheckbox;

class TargetsRecurringCheckboxRepository extends Repository implements TargetsRecurringCheckboxContract
{
    protected $filtersValid = [];

    protected $includesValid = [
        'updates',
    ];

    protected $sortsValid = [
        'id',
    ];

    /**
     * @param array $additionalInput
     */
    public function __construct(array $additionalInput = [])
    {
        $this->model = new TargetRecurringCheckbox();
        $this->query = $this->model->query();
        parent::__construct($additionalInput);
    }

    public function applyFilters()
    {
        //
    }
}
