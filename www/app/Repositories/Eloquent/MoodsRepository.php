<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use CreateUsersTable;
use StartMeUp\Contracts\Repositories\MoodsContract;
use StartMeUp\Models\Mood;

class MoodsRepository extends Repository implements MoodsContract
{
    protected $filtersValid = [
        CreateUsersTable::TABLE,
    ];

    protected $includesValid = [
        'user',
    ];

    protected $sortsValid = [
        'created_at',
        'feeling',
    ];

    /**
     * @param array $additionalInput
     */
    public function __construct(array $additionalInput = [])
    {
        $this->model = new Mood();
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
