<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use CreateUsersTable;
use StartMeUp\Contracts\Repositories\InterestsContract;
use StartMeUp\Models\Interest;

class InterestsRepository extends Repository implements InterestsContract
{
    protected $filtersValid = [
        CreateUsersTable::TABLE,
    ];

    protected $includesValid = [];

    protected $sortsValid = [
        'order',
    ];

    /**
     * @param array $additionalInput
     */
    public function __construct(array $additionalInput = [])
    {
        $this->model = new Interest();
        $this->query = $this->model->query();
        parent::__construct($additionalInput);
    }

    public function applyFilters()
    {
        foreach ($this->filters as $filter => $value) {
            switch ($filter) {
                case CreateUsersTable::TABLE:
                    $this->model = $this->model->where(CreateUsersTable::FK, $value);
                    break;
                default:
                    break;
            }
        }
    }
}
