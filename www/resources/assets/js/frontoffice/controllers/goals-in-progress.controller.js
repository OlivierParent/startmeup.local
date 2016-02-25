/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('GoalsInProgressCtrl', GoalsInProgressCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	GoalsInProgressCtrl.$inject = [
		// Angular
		'$location',
		'$log',
		// Custom
		'StorageFactory',
		'UserCategoryResourceFactory'
	];

	function GoalsInProgressCtrl(
		// Angular
		$location,
		$log,
		// Custom
		StorageFactory,
		UserCategoryResourceFactory
	) {
		$log.info('GoalsInProgressCtrl');
		// ViewModel
		// =========
		var vm = this;

		vm.user  = StorageFactory.Local.getUserModel('user');
		vm.categories = loadUserCategory();

		vm.goto = goto;

		// Functions
		// =========
		function goto(uri) {
			$location.path(uri);
		}

		function loadUserCategory() {
			$log.info('loadUserGoal');
			var params = {
				userId: vm.user.id
			};
			var categories = UserCategoryResourceFactory.queryWithGoalsInProgress(params);
			categories.$promise
				.then(loadUserCategoryResourceSuccess)
				.catch(loadUserCategoryResourceError);

			return categories;
		}

		function loadUserCategoryResourceError(reason) {
			$log.error('loadUserCategoryResourceError:', reason);
		}

		function loadUserCategoryResourceSuccess(response) {
			$log.info('loadUserCategoryResourceSuccess:', response);
		}
	}

})();
