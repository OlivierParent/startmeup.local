/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('LogInCtrl', LogInCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	LogInCtrl.$inject = [
		// Angular
		'$log',
		'$scope',
		'$window',
		// Custom
		'AuthUserResourceFactory',
		'DialogFactory',
		'StorageFactory',
		'ToastFactory',
		'UserModelFactory'
	];

	function LogInCtrl(
		// Angular
		$log,
		$scope,
		$window,
		// Custom
		AuthUserResourceFactory,
		DialogFactory,
		StorageFactory,
		ToastFactory,
		UserModelFactory
	) {
		// ViewModel
		var vm = this;

		// The function is inherited from the parent controller (AppCtrl) scope.
		vm.openLeftSidenav = $scope.openLeftSidenav;

		vm.processForm = processForm;

		vm.user = new UserModelFactory();

		// Functions
		// =========
		function loginError(reason) {
			$log.error('loginError:', reason);
			DialogFactory
				.showItems('Could not log you in!', reason.errors);
		}

		function loginSuccess(response) {
			$log.log('loginSuccess:', response);
			ToastFactory
				.show('User logged in!')
				.finally(function() {
					vm.user.id = response.id;
					StorageFactory.Local.setObject('user', vm.user);
					$window.location.href = '#/goals';
				});
		}

		function processForm(event) {
			event.preventDefault();
			if ($scope.login_form.$valid) {
				$log.log('user: ', vm.user);

				var authUserResource = new AuthUserResourceFactory();
				authUserResource.user = vm.user;
				authUserResource.$login()
					.then(loginSuccess)
					.catch(loginError);
			} else {
				ToastFactory
					.show('Please fill in the required fields to continue!');
			}
		}
	}

})();
