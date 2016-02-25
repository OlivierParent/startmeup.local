<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Http\Controllers;

class FrontofficeController extends Controller
{
    /**
     * Show the Front Office to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('frontoffice');
    }
}
