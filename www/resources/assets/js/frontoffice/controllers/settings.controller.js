/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('SettingsCtrl', SettingsCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	SettingsCtrl.$inject = [
		// Angular
		'$scope'
	];

	function SettingsCtrl(
		// Angular
		$scope
	) {
		var vm = this;

	}

})();
