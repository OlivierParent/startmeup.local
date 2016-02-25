/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('GoalEditCtrl', GoalEditCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	GoalEditCtrl.$inject = [
		// Angular
		'$log',
		'$routeParams',
		'$scope',
		'$window',
		// Constants
		'INCREMENT_TYPES',
		'REPEAT_TYPES',
		// Custom
		'GoalResourceFactory',
		'StorageFactory',
		'TargetCheckboxResourceFactory',
		'TargetDurationResourceFactory',
		'TargetRecurringCheckboxResourceFactory'
	];

	function GoalEditCtrl(
		// Angular
		$log,
		$routeParams,
		$scope,
		$window,
		// Constants
		INCREMENT_TYPES,
		REPEAT_TYPES,
		// Custom
		GoalResourceFactory,
		StorageFactory,
		TargetCheckboxResourceFactory,
		TargetDurationResourceFactory,
		TargetRecurringCheckboxResourceFactory

	) {
		$log.info('GoalEditCtrl');
		// ViewModel
		// =========
		var vm = this;

		vm.categories       = StorageFactory.Local.getCategoryModel('categories');
		vm.user             = StorageFactory.Local.getUserModel('user');
		vm.category         = _.find(vm.categories, isCurrentCategoryFilter);
		vm.goal             = _.find(vm.category.goals, isCurrentGoalFilter);
		vm.goal.category_id = vm.category.id;
		vm.goal.user_id     = vm.user.id;

		// User Interface variables
		vm.$$INCREMENT_TYPES = INCREMENT_TYPES;
		vm.$$REPEAT_TYPES    = REPEAT_TYPES;

		vm.save = save;

		// Watchers
		// --------
		$scope.$watch('vm.goal.target.time_estimated', watchTargetDurationHandler);
		$scope.$watch('vm.goal.target.time_increment', watchTargetDurationHandler);

		// Functions
		// =========
		function gotoOverview() {
			$window.location.href = '#/goals';
		}

		function save(event) {
			event.preventDefault();

			$log.log('vm.goal:', vm.goal);

			updateGoal();
		}

		// Goal
		// ----
		function updateGoal() {
			$log.info('updateGoal');
			var goalResource = new GoalResourceFactory();
			goalResource.goal = vm.goal;
			var params = {
				goalId: vm.goal.id
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
			updateTarget();
		}

		// Target
		// -----
		function updateTarget() {
			$log.info('updateTarget');
			if (vm.goal.$$hasTargetTypeCheckbox()) {
				updateTargetCheckbox();
			} else
			if (vm.goal.$$hasTargetTypeRecurringCheckbox()) {
				updateTargetRecurringCheckbox();
			} else
			if (vm.goal.$$hasTargetTypeDuration()) {
				updateTargetDuration();
			}
		}

		// Target Checkbox
		// ---------------
		function updateTargetCheckbox() {
			$log.info('updateTargetCheckbox');
			var targetCheckboxResource = new TargetCheckboxResourceFactory();
			targetCheckboxResource.target = vm.goal.target;
			var params = {
				targetCheckboxId: vm.goal.target.id
			};
			targetCheckboxResource.$update(params)
				.then(updateTargetCheckboxResourceSuccess)
				.catch(updateTargetCheckboxResourceError);
		}

		function updateTargetCheckboxResourceError(reason) {
			$log.error('updateTargetCheckboxResourceError:', reason);
		}

		function updateTargetCheckboxResourceSuccess(response) {
			$log.log('updateTargetCheckboxResourceSuccess:', response);
			gotoOverview();
		}

		// Target Duration
		// ---------------
		function updateTargetDuration() {
			$log.info('updateTargetDuration');
			var targetDurationResource = new TargetDurationResourceFactory();
			targetDurationResource.target = vm.goal.target;
			var params = {
				targetDurationId: vm.goal.target.id
			};
			targetDurationResource.$update(params)
				.then(updateTargetDurationResourceSuccess)
				.catch(updateTargetDurationResourceError);
		}

		function updateTargetDurationResourceError(reason) {
			$log.error('updateTargetDurationResourceError:', reason);
		}

		function updateTargetDurationResourceSuccess(response) {
			$log.log('updateTargetDurationResourceSuccess:', response);
			gotoOverview();
		}

		// Target Recurring Checkbox
		// -------------------------
		function updateTargetRecurringCheckbox() {
			$log.info('updateTargetRecurringCheckbox');
			var targetRecurringCheckboxResource = new TargetRecurringCheckboxResourceFactory();
			targetRecurringCheckboxResource.target = vm.goal.target;
			var params = {
				targetRecurringCheckboxId: vm.goal.target.id
			};
			targetRecurringCheckboxResource.$update(params)
				.then(updateTargetRecurringCheckboxResourceSuccess)
				.catch(updateTargetRecurringCheckboxResourceError);
		}

		function updateTargetRecurringCheckboxResourceError(reason) {
			$log.error('updateTargetRecurringCheckboxResourceError:', reason);
		}

		function updateTargetRecurringCheckboxResourceSuccess(response) {
			$log.log('updateTargetRecurringCheckboxResourceSuccess:', response);
			gotoOverview();
		}

		// Filters
		// -------
		function isCurrentCategoryFilter(category) {
			return parseInt(category.id) === parseInt($routeParams.categoryId);
		}

		function isCurrentGoalFilter(goal) {
			return parseInt(goal.id) === parseInt($routeParams.goalId);
		}

		// Watch Handlers
		// --------------
		function watchTargetDurationHandler() {
			if (vm.goal.$$hasTargetTypeDuration()) {
				vm.goal.target.$$updateDuration();
			}
		}
	}

})();
