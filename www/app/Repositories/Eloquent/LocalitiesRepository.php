<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use StartMeUp\Contracts\Repositories\LocalitiesContract;
use StartMeUp\Models\Locality;

class LocalitiesRepository extends Repository implements LocalitiesContract
{
    protected $filtersValid = [
        'name',
        'postal_code',
    ];

    protected $includesValid = [
        'region',
        'region.country',
    ];

    protected $sortsValid = [
        'name',
        'postal_code',
    ];

    /**
     * @param array $additionalInput
     */
    public function __construct(array $additionalInput = [])
    {
        $this->model = new Locality();
        $this->query = $this->model->query();
        $this->addSortsDefault(['postal_code' => self::ORDER_ASCENDING, 'name' => self::ORDER_ASCENDING]);
        parent::__construct($additionalInput);
    }

    public function applyFilters()
    {
        foreach ($this->filters as $filter => $value) {
            switch ($filter) {
                case 'name':
                    $this->model = $this->model->where('name', self::SQL_LIKE, "%${value}%");
                    break;
                case 'postal_code':
                    $this->model = $this->model->where('postal_code', self::SQL_LIKE, "%${value}%");
                    break;
                default:
                    break;
            }
        }
    }
}
