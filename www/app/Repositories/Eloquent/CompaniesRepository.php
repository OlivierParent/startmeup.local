<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use StartMeUp\Contracts\Repositories\CompaniesContract;
use StartMeUp\Models\Company;

class CompaniesRepository extends Repository implements CompaniesContract
{
    protected $includesValid = [
        'address',
        'address.locality',
        'address.locality.region',
        'address.locality.region.country',
    ];

    /**
     * @param array $additionalInput
     */
    public function __construct(array $additionalInput = [])
    {
        $this->model = new Company();
        $this->query = $this->model->query();
        parent::__construct($additionalInput);
    }

    public function applyFilters()
    {
        //
    }
}
