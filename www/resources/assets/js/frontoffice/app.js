/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	// StartMeUpBuddy.io application
	// -----------------------------

	angular.module('smuApplication', [
		// Angular module dependencies
		'ngAnimate',
		'ngMaterial',
		'ngMessages',
		//'ngNewRouter',
		'ngResource',
		'ngRoute',

		// StartMeUpBuddy.io module dependencies
		'smuControllers',
		'smuDirectives',
		'smuFilters',
		'smuServices'
	]);

	// StartMeUpBuddy.io module declarations
	// -------------------------------------

	angular.module('smuControllers', []);
	angular.module('smuDirectives' , []);
	angular.module('smuFilters'    , []);
	angular.module('smuServices'   , []);

})();
