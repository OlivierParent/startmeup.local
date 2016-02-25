<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use StartMeUp\Contracts\Repositories\CountriesContract;
use StartMeUp\Models\Country;

class CountriesRepository extends Repository implements CountriesContract
{
    protected $filtersValid = [
        'iso',
        'name',
    ];

    protected $sortsValid = [
        'iso',
        'name',
    ];

    /**
     * @param array $additionalInput
     *
     * @throws \Exception
     */
    public function __construct(array $additionalInput = [])
    {
        $this->model = new Country();
        $this->query = $this->model->query();
        $this->addSortDefault('name');
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
