<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Contracts\Repositories;

interface Contract
{
    /**
     * @return mixed
     */
    public function get();

    /**
     * @return mixed
     */
    public function getCollection();
}
