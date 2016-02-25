/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('RegistrationStep4Ctrl', RegistrationStep4Ctrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	RegistrationStep4Ctrl.$inject = [
		// Angular
		'$log',
		// Custom
		'RegistrationFormStateFactory'
	];

	function RegistrationStep4Ctrl(
		// Angular
		$log,
		// Custom
		RegistrationFormStateFactory
	) {
		$log.info('Registration: step 4');
		// ViewModel
		// =========
		var vm = this;

		var formState = RegistrationFormStateFactory; // Get the form state.
		angular.merge(vm, formState);

		$log.log(vm);

		// Functions
		// =========

	}

})();
