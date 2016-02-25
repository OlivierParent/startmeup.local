<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use StartMeUp\Contracts\Repositories\UpdatesDurationContract;
use StartMeUp\Models\UpdateDuration;

class UpdatesDurationRepository extends Repository implements UpdatesDurationContract
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
        $this->model = new UpdateDuration();
        $this->query = $this->model->query();
        parent::__construct($additionalInput);
    }

    public function applyFilters()
    {
        //
    }
}
