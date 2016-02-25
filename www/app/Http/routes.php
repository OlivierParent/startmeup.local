<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

// Landing Page
// ============
Route::get('/', function () {
    return view('landing');
});

// Application Programming Interface Routes
// ========================================
Route::group(
    [
        'prefix' => 'api',
    ],
    function () {
        Debugbar::disable();

        // API version 1
        // -------------
        Route::group(
            [
                'namespace' => 'Api', // namespace StartMeUp\Http\Controllers\Api
                'prefix' => 'v1',
            ],
            function () {
                Route::get('/', function () {
                    $uriRoot = Request::root();

                    return [
                        "${uriRoot} API" => [
                            'version' => 1,
                        ],
                    ];
                });
                Route::get('users/{users}/moods/statistics', [
                    'as' => 'api.v1.users.moods.statistics',
                    'uses' => 'UsersMoodsController@statistics',
                ]);
                Route::options('/', function () {
                    return [
                        'X-CSRF-TOKEN' => csrf_token(),
                    ];
                });
                Route::post('auth', [
                    'as' => 'api.v1.auth',
                    'uses' => 'AuthController@login',
                ]);
                $options = [
                    'except' => [
                        'create',
                        'edit',
                    ],
                ];
                Route::resource('addresses', 'AddressesController', $options);
                Route::resource('companies', 'CompaniesController', $options);
                Route::resource('countries', 'CountriesController', $options);
                Route::resource('goals', 'GoalsController', $options);
                Route::resource('interests', 'InterestsController', $options);
                Route::resource('localities', 'LocalitiesController', $options);
                Route::resource('locations', 'LocationsController', $options);
                Route::resource('regions', 'RegionsController', $options);
                Route::resource('targets/checkbox', 'TargetsCheckboxController', $options);
                Route::resource('targets/recurringcheckbox', 'TargetsRecurringCheckboxController', $options);
                Route::resource('targets/duration', 'TargetsDurationController', $options);
                Route::resource('updates/recurringcheckbox', 'UpdatesRecurringCheckboxController', $options);
                Route::resource('updates/duration', 'UpdatesDurationController', $options);
                Route::resource('users', 'UsersController', $options);
                Route::resource('users.categories', 'UsersCategoriesController', $options);
                Route::resource('users.goals', 'UsersGoalsController', $options);
                Route::resource('users.moods', 'UsersMoodsController', $options);
                Route::resource('users.settings', 'UsersSettingsController', $options);
            }
        );
    }
);

// Back Office Routes
// ==================
Route::group(
    [
        'as' => 'backoffice.',
        'prefix' => 'backoffice',
    ],
    function () {
        Route::get('/', [
            'as' => 'home',
            'uses' => 'BackofficeController@index',
        ]);
    }
);

// Front Office Routes
// ===================
Route::group(
    [
        'as' => 'frontoffice.',
        'prefix' => 'frontoffice',
    ],
    function () {
        Debugbar::disable();
        Route::get('/', [
            'as' => 'home',
            'uses' => 'FrontofficeController@index',
        ]);
    }
);

// Style Guide Routes
// ==================
Route::get('/styleguide', [
    'as' => 'styleguide.home',
    function () {
        Debugbar::disable();

        return view('styleguide');
    },
]);
