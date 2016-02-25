<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Repositories\Eloquent;

use Exception;
use Input;

abstract class Repository
{
    // Valid arguments
    const ARG_FILTER = 'filter';
    const ARG_INCLUDE = 'include';
    const ARG_LIMIT = 'limit';
    const ARG_SORT = 'sort';

    const LIMIT_DEFAULT = self::LIMIT_MIN;
    const LIMIT_MAX = 1000;
    const LIMIT_MIN = 100;

    const ORDER_ASCENDING = 'ASC';
    const ORDER_DEFAULT = null;
    const ORDER_DESCENDING = 'DESC';

    const SQL_LIKE = 'LIKE';

    /**
     * @var array
     */
    protected $input = [];

    /**
     * @var null
     */
    protected $model = null;

    /**
     * @var null
     */
    protected $query = null;

    /**
     * @var null
     */
    protected $paginator = null;

    /**
     * @var int
     */
    protected $limit = self::LIMIT_DEFAULT;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $filtersDefault = [];

    /**
     * @var array
     */
    protected $filtersValid = [];

    /**
     * @var array
     */
    protected $includes = [];

    /**
     * @var array
     */
    protected $includesDefault = [];

    /**
     * @var array
     */
    protected $includesValid = [];

    /**
     * @var array
     */
    protected $sorts = [];

    /**
     * @var array
     */
    protected $sortsDefault = [];

    /**
     * @var array
     */
    protected $sortsValid = [];

    /**
     * @param array $additionalInput
     */
    public function __construct(array $additionalInput = [])
    {
        $input = array_filter(Input::only(self::ARG_FILTER, self::ARG_INCLUDE, self::ARG_LIMIT, self::ARG_SORT)); // array_filter removes empties
        $this->input = array_merge_recursive($input, $additionalInput);

        // Filter result set
        if (isset($this->input[self::ARG_FILTER])) {
            $this->addFilters($this->input[self::ARG_FILTER]);
        }
        $this->applyFilters();

        // Order filtered result set
        if (isset($this->input[self::ARG_SORT])) {
            $this->addSorts($this->input[self::ARG_SORT]);
        }
        $this->applySorts();

        // Limit and paginate filtered result set
        if (isset($this->input[self::ARG_LIMIT])) {
            $this->setLimit($this->input[self::ARG_LIMIT]);
        }
        $this->applyLimit();

        // Load included models
        if (isset($this->input[self::ARG_INCLUDE])) {
            $this->addIncludes($this->input[self::ARG_INCLUDE]);
        }
        $this->applyIncludes(true);
    }

    /**
     * @param $filter
     * @param $value
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function addFilter($filter, $value)
    {
        if (in_array($filter, $this->filtersValid)) {
            $this->filters[$filter] = $value;
        } else {
            throw new Exception("Invalid filter: `${filter}`");
        }

        return $this;
    }

    /**
     * @param array $filters
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function addFilters(array $filters)
    {
        foreach ($filters as $filter => $value) {
            $this->addFilter($filter, $value);
        }

        return $this;
    }

    abstract public function applyFilters();

    /**
     * @param $include
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function addInclude($include)
    {
        if (in_array($include, $this->includesValid)) {
            array_push($this->includes, $include);
        } else {
            throw new Exception("Invalid include: `${include}`");
        }

        return $this;
    }

    /**
     * @param $include
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function addIncludeDefault($include)
    {
        if (in_array($include, $this->includesValid)) {
            array_push($this->includesDefault, $include);
        } else {
            throw new Exception("Invalid default include: `${include}`");
        }

        return $this;
    }

    /**
     * @param array $includes
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function addIncludes(array $includes)
    {
        foreach ($includes as $include) {
            $this->addInclude($include);
        }

        return $this;
    }

    /**
     * @param array $includes
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function addIncludesDefault(array $includes)
    {
        foreach ($includes as $include) {
            $this->addIncludeDefault($include);
        }

        return $this;
    }

    /**
     * @param bool $usePaginator
     */
    public function applyIncludes($usePaginator = false)
    {
        $includes = (empty($this->includes)) ? $this->includesDefault : $this->includes;

        $models = ($usePaginator) ? $this->paginator : $this->model;
        foreach ($includes as $include) {
            $models->load($include);
        }
    }

    /**
     * @param $column
     * @param string $direction
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function addSort($column, $direction = self::ORDER_ASCENDING)
    {
        if (in_array($column, $this->sortsValid)) {
            $this->sorts[$column] = (strtoupper($direction) === self::ORDER_DESCENDING) ? self::ORDER_DESCENDING : self::ORDER_ASCENDING;
        } else {
            throw new Exception("Invalid sort column: `${column}`");
        }

        return $this;
    }

    /**
     * @param $column
     * @param string $direction
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function addSortDefault($column, $direction = self::ORDER_ASCENDING)
    {
        if (in_array($column, $this->sortsValid)) {
            $this->sortsDefault[$column] = (strtoupper($direction) === self::ORDER_DESCENDING) ? self::ORDER_DESCENDING : self::ORDER_ASCENDING;
        } else {
            throw new Exception("Invalid sort default column: `${column}`");
        }

        return $this;
    }

    /**
     * @param array $sorts
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function addSorts(array $sorts)
    {
        foreach ($sorts as $column => $direction) {
            $this->addSort($column, $direction);
        }

        return $this;
    }

    /**
     * @param array $sorts
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function addSortsDefault(array $sorts)
    {
        foreach ($sorts as $column => $direction) {
            $this->addSortDefault($column, $direction);
        }

        return $this;
    }

    /**
     *
     */
    public function applySorts()
    {
        $sorts = (empty($this->sorts)) ? $this->sortsDefault : $this->sorts;

        foreach ($sorts as $column => $direction) {
            $this->model = $this->model->orderBy($column, $direction);
        }
    }

    /**
     * @param $limit
     *
     * @return $this
     */
    public function setlimit($limit)
    {
        $this->limit = ($limit < self::LIMIT_MAX) ? $limit : self::LIMIT_MAX;

        return $this;
    }

    /**
     *
     */
    public function applyLimit()
    {
        $this->paginator = $this->model->paginate($this->limit);
        $this->paginator->appends('limit', $this->limit); // @link http://laravel.com/docs/5.0/pagination#appending-to-pagination-links
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        $this->model = $this->model->find($id);
        $this->applyIncludes();

        return $this->model;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->paginator->getCollection();
    }

    /**
     */
    public function getPaginator()
    {
        return $this->paginator;
    }
}
