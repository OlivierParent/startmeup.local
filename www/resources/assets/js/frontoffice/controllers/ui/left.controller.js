/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('LeftCtrl', LeftCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	LeftCtrl.$inject = [
		// Angular
		'$log',
		// Angular Material Design
		'$mdSidenav'
	];

	function LeftCtrl(
		// Angular
		$log,
		// Angular Material Design
		$mdSidenav
	) {
		$log.info('LeftCtrl');
		// ViewModel
		var vm = this;

		vm.close = close;

		// Functions
		// =========
		function close() {
			$mdSidenav('left')
				.close()
				.then(function(){
					$log.log('Left sidenav has done closing!');
				});

		}

	}

})();
