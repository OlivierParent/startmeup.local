/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('RegistrationStep1Ctrl', RegistrationStep1Ctrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	RegistrationStep1Ctrl.$inject = [
		// Angular
		'$log',
		'$scope',
		'$window',
		// Custom
		'RegistrationFormStateFactory',
		'ToastFactory'
	];

	function RegistrationStep1Ctrl(
		// Angular
		$log,
		$scope,
		$window,
		// Custom
		RegistrationFormStateFactory,
		ToastFactory
	) {
		$log.info('Registration: step 1');
		// ViewModel
		var vm = this;

		// Get the form state.
		var formState = RegistrationFormStateFactory;
		vm.user = formState.user;
		$log.log('vm:', vm);

		vm.processFormStep = processFormStep;

		// Functions
		// =========
		function gotoNextStep() {
			$window.location.href = '#/registration/step/2/of/4';
		}

		function processFormStep(event) {
			event.preventDefault();
			if ($scope.registration_form.$valid) {
				// Set the form state.
				formState.user = vm.user;
				gotoNextStep();
			} else {
				ToastFactory
					.show('Please fill in the required fields to continue!');
			}
		}

	}

})();
