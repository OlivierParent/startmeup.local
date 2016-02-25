/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('ToastCtrl', ToastCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	ToastCtrl.$inject = [
		// Angular Material Design
		'$mdToast'
	];

	function ToastCtrl(
		// Angular Material Design
		$mdToast
	) {
		// ViewModel
		var vm = this;

		vm.hide = hide;

		// Functions
		// =========
		function hide() {
			$mdToast.hide();
		}
	}

})();
