<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use CreateUsersTable;
use StartMeUp\Contracts\Repositories\GoalsContract;
use StartMeUp\Models\Goal;

class GoalsRepository extends Repository implements GoalsContract
{
    protected $filtersValid = [
        CreateUsersTable::TABLE,
        'in_progress',
    ];

    protected $includesValid = [
        'target',
    ];

    protected $sortsValid = [
        'category',
        'order',
    ];

    /**
     * @param array $additionalInput
     */
    public function __construct(array $additionalInput = [])
    {
        $this->model = new Goal();
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
                case 'in_progress':
                    $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                    $this->model = $this->model->where('in_progress', (bool) $value);
                    break;
                default:
                    break;
            }
        }
    }
}
