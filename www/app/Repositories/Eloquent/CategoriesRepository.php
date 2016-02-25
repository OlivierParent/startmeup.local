<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use CreateGoalsTable;
use CreateUsersTable;
use StartMeUp\Contracts\Repositories\CategoriesContract;
use StartMeUp\Models\Category;

class CategoriesRepository extends Repository implements CategoriesContract
{
    /**
     * @var array
     */
    protected $filtersValid = [
        CreateGoalsTable::TABLE . '.in_progress',
        CreateUsersTable::TABLE,
    ];

    /**
     * @var array
     */
    protected $includesValid = [
        CreateGoalsTable::TABLE,
        CreateGoalsTable::TABLE . '.target',
    ];

    /**
     * @var array
     */
    protected $sortsValid = [
        'order',
    ];

    /**
     * @param array $additionalInput
     */
    public function __construct(array $additionalInput = [])
    {
        $this->model = new Category();
        $this->query = $this->model->query();
        parent::__construct($additionalInput);
    }

    public function applyFilters()
    {
        foreach ($this->filters as $filter => $value) {
            switch ($filter) {
                case CreateGoalsTable::TABLE . '.in_progress': // filter[goals.in_progress]=true
                    $value = (bool) filter_var($value, FILTER_VALIDATE_BOOLEAN);
                    $this->model = $this->model->with([CreateGoalsTable::TABLE => function ($query) use ($value) {
                        $query->inProgress($value);
                    }]);
                    break;
                case CreateUsersTable::TABLE: // filter[users]=1
                    $this->model = $this->model->where(CreateUsersTable::FK, $value);
                    break;
                default:
                    break;
            }
        }
    }
}
