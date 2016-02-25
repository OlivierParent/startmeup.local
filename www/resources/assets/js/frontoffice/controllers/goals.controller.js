/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('GoalsCtrl', GoalsCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	GoalsCtrl.$inject = [
		// Angular
		'$log',
		// Custom
		'StorageFactory',
		'GoalResourceFactory',
		'UserCategoryResourceFactory'
	];

	function GoalsCtrl(
		// Angular
		$log,
		// Custom
		StorageFactory,
		GoalResourceFactory,
		UserCategoryResourceFactory
	) {
		$log.info('GoalsCtrl');
		// ViewModel
		// =========
		var vm = this;

		vm.user       = StorageFactory.Local.getUserModel('user');
		vm.categories = loadUserCategory();

		vm.goalChanged = goalChanged;

		// Functions
		// =========

		/**
		 * Update Goal when changed.
		 */
		function goalChanged(goal) {
			$log.log(goal);
			updateGoal(goal);
		}

		// Goal
		// ----
		function updateGoal(goal) {
			$log.info('updateGoal');
			var params = {
				goalId: goal.id
			};
			var goalResource = new GoalResourceFactory();
			goalResource.goal = {
				user_id    : vm.user.id,
				name       : goal.name,
				in_progress: goal.in_progress
			};
			goalResource.$update(params)
				.then(updateGoalResourceSuccess)
				.catch(updateGoalResourceError);
		}

		function updateGoalResourceError(reason) {
			$log.error('updateGoalResourceError:', reason);
		}

		function updateGoalResourceSuccess(response) {
			$log.log('updateGoalResourceSuccess:', response);
		}

		// UserCategory
		// ------------
		function loadUserCategory() {
			$log.info('loadUserCategory');
			var params = {
				'userId'     : vm.user.id,
				'sort[order]': 'asc'
			};
			var categories = UserCategoryResourceFactory.queryWithTarget(params);

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
			StorageFactory.Local.setObject('categories', vm.categories);
		}
	}

})();
