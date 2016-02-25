/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('RegistrationStep2Ctrl', RegistrationStep2Ctrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	RegistrationStep2Ctrl.$inject = [
		// Angular
		'$log',
		'$scope',
		'$window',
		// Custom
		'DialogFactory',
		'InterestResourceFactory',
		'RegistrationFormStateFactory',
		'ToastFactory',
		'UserResourceFactory',
		'UserSettingsResourceFactory'
	];

	function RegistrationStep2Ctrl(
		// Angular
		$log,
		$scope,
		$window,
		// Custom
		DialogFactory,
		InterestResourceFactory,
		RegistrationFormStateFactory,
		ToastFactory,
		UserResourceFactory,
		UserSettingsResourceFactory
	) {
		$log.info('Registration: step 2');
		// ViewModel
		// =========
		var vm = this;

		// Get the form state.
		var formState = RegistrationFormStateFactory;
		vm.settings = formState.settings;
		vm.user     = formState.user;
		$log.log('vm:', vm);

		vm.processFormStep = processFormStep;

		loadInterest();

		// Functions
		// =========
		function gotoNextStep() {
			$window.location.href = '#/registration/step/3/of/4';
		}

		function processFormStep(event) {
			event.preventDefault();

			$log.log('user: ', vm.user);
			if ($scope.registration_form.$valid) {
				// Set the form state.
				formState.settings = vm.settings;
				formState.user     = vm.user;
				saveUser();
			} else {
				ToastFactory.show('Please fill in the required fields to continue!');
			}
		}

		// Interest
		// --------
		function loadInterest() {
			$log.info('loadInterest');
			InterestResourceFactory.query()
				.$promise
					.then(loadInterestResourceSuccess)
					.catch(loadInterestResourceError);
		}

		function loadInterestResourceError(reason) {
			$log.error('loadInterestResourceError:', reason);
		}

		function loadInterestResourceSuccess(response) {
			$log.log('loadInterestResourceSuccess:', response);
			vm.user.$$interests = response.resource; // response.resource contains the data processed by the interceptor, while $promise contains raw data.
		}

		// User
		// ----
		function saveUser() {
			$log.info('saveUser');
			if (!angular.isNumber(formState.user.id)) {
				var userResource = new UserResourceFactory();
				userResource.user = formState.user;
				userResource.$save()
					.then(saveUserResourceSuccess)
					.catch(saveUserResourceError);
			} else {
				$log.warn('User already exists');
				updateUserSettings();
			}
		}

		function saveUserResourceError(reason) {
			$log.error('saveUserResourceError:', reason);
			DialogFactory
				.showItems('The user profile could not be saved!', reason.errors);
		}

		function saveUserResourceSuccess(response) {
			$log.log('saveUserResourceSuccess:', response);
            // Update the form state.
			formState.user.id          = response.id;
			formState.settings.id      = response.settings_id;
			formState.settings.user_id = response.id;
			updateUserSettings();
		}

		// UserSettings
		// ------------
		function updateUserSettings() {
			$log.info('updateUserSettings');
			var userSettingsResource = new UserSettingsResourceFactory;
			var params = {
				userId    : formState.user.id,
				settingsId: formState.settings.id
			};
			userSettingsResource.$get(params)
				.then(function () {
					angular.merge(userSettingsResource, formState.settings);
					userSettingsResource.$update(params)
						.then(updateUserSettingsResourceSuccess)
						.catch(updateUserSettingsResourceError);
				});
		}

		function updateUserSettingsResourceError(reason) {
			$log.error('saveUserSettingsResourceError:', reason);
			DialogFactory
				.showItems('The user settings could not be updated!', reason.errors);
		}

		function updateUserSettingsResourceSuccess(response) {
			$log.log('saveUserSettingsResourceSuccess:', response);
			ToastFactory
				.show('User settings updated!')
				.finally(gotoNextStep);
		}

	}

})();
