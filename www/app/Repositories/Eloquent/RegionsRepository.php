<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use StartMeUp\Contracts\Repositories\RegionsContract;
use StartMeUp\Models\Region;

class RegionsRepository extends Repository implements RegionsContract
{
    protected $filtersValid = [
        'iso',
        'name',
    ];

    protected $includesValid = [
        'country',
    ];

    protected $sortsValid = [
        'iso',
        'name',
    ];

    /**
     * @param array $additionalInput
     */
    public function __construct(array $additionalInput = [])
    {
        $this->model = new Region();
        $this->query = $this->model->query();
        parent::__construct($additionalInput);
    }

    public function applyFilters()
    {
        foreach ($this->filters as $filter => $value) {
            switch ($filter) {
                case 'iso':
                    $this->model = $this->model->where('iso', self::SQL_LIKE, "%${value}%");
                    break;
                case 'name':
                    $this->model = $this->model->where('name', self::SQL_LIKE, "%${value}%");
                    break;
                default:
                    break;
            }
        }
    }
}
