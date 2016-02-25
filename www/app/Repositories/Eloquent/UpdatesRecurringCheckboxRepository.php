<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use StartMeUp\Contracts\Repositories\UpdatesRecurringCheckboxContract;
use StartMeUp\Models\UpdateRecurringCheckbox;

class UpdatesRecurringCheckboxRepository extends Repository implements UpdatesRecurringCheckboxContract
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
        $this->model = new UpdateRecurringCheckbox();
        $this->query = $this->model->query();
        parent::__construct($additionalInput);
    }

    public function applyFilters()
    {
        //
    }
}
