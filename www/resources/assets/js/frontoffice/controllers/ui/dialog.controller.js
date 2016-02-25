/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('DialogCtrl', DialogCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	DialogCtrl.$inject = [
		// Angular Material Design
		'$mdDialog'
	];

	function DialogCtrl(
		// Angular Material Design
		$mdDialog
	) {
		// ViewModel
		var vm = this;

		vm.hide = hide;

		// Functions
		// =========
		function hide() {
			$mdDialog.hide();
		}
	}

})();
