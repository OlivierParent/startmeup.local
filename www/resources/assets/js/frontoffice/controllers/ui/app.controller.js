/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('AppCtrl', AppCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	AppCtrl.$inject = [
		// Angular
		'$log',
		'$scope',
		// Angular Material Design
		'$mdSidenav'
	];

	function AppCtrl(
		// Angular
		$log,
		$scope,
		// Angular Material Design
		$mdSidenav
	) {
		$log.info('AppCtrl');

		// Add the function to the AppCtrl scope. It will be inherited by the child controller scope
		$scope.openLeftSidenav = openLeftSidenav;

		// Functions
		// =========
		function openLeftSidenav() {
			$log.log('openLeftSidenav');

			$mdSidenav('left')
				.open();
		}
	}

})();
