/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('GoalUpdateCtrl', GoalUpdateCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	GoalUpdateCtrl.$inject = [
		// Angular
		'$log',
		'$routeParams',
		'$window',
		// Constants
		'INCREMENT_TYPES',
		'REPEAT_TYPES',
		// Custom
		'StorageFactory',
		'TargetCheckboxResourceFactory',
		'UpdateDurationResourceFactory',
		'UpdateRecurringCheckboxResourceFactory'
	];

	function GoalUpdateCtrl(
		// Angular
		$log,
		$routeParams,
		$window,
		// Constants
		INCREMENT_TYPES,
		REPEAT_TYPES,
		// Custom
		StorageFactory,
		TargetCheckboxResourceFactory,
		UpdateDurationResourceFactory,
		UpdateRecurringCheckboxResourceFactory
	) {
		$log.info('GoalUpdateCtrl');
		// ViewModel
		// =========
		var vm = this;

		vm.categories       = StorageFactory.Local.getCategoryModel('categories');
		vm.user             = StorageFactory.Local.getUserModel('user');
		vm.category         = _.find(vm.categories, isCurrentCategoryFilter);
		vm.goal             = _.find(vm.category.goals, isCurrentGoalFilter);
		vm.goal.category_id = vm.category.id;
		vm.goal.user_id     = vm.user.id;

		if (vm.goal.$$hasTargetTypeDuration()) {
			vm.goal.target.update.$$setTimeIncrement(vm.goal.target.time_increment);
		}

		// User Interface variables
		vm.$$INCREMENT_TYPES = INCREMENT_TYPES;
		vm.$$REPEAT_TYPES    = REPEAT_TYPES;
		vm.$$showGoalDetails = false;

		vm.save              = save;
		vm.toggleGoalDetails = toggleGoalDetails;

		$log.log('vm.goal:', vm.goal);

		// Functions
		// =========
		function gotoOverview() {
			$window.location.href = '#/goals/in-progress';
		}

		function save(event) {
			event.preventDefault();

			$log.log('vm.goal:', vm.goal);

			updateTarget();
		}

		function toggleGoalDetails(event) {
			event.preventDefault();

			vm.$$showGoalDetails = !vm.$$showGoalDetails;
			$log.log('vm.$$showGoalDetails:', vm.$$showGoalDetails);
		}

		function updateTarget() {
			$log.info('updateTarget');
			if (vm.goal.$$hasTargetTypeCheckbox()) {
				updateTargetCheckbox();
			} else
			if (vm.goal.$$hasTargetTypeRecurringCheckbox()) {
				saveUpdateRecurringCheckbox();
			} else
			if (vm.goal.$$hasTargetTypeDuration()) {
				saveUpdateDuration();
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
		function saveUpdateDuration() {
			$log.info('saveUpdateDuration');
			vm.goal.target.update.target_id = vm.goal.target.id;
			var updateDurationResource = new UpdateDurationResourceFactory();
			updateDurationResource.update = vm.goal.target.update;
			updateDurationResource.$save()
				.then(saveUpdateDurationResourceSuccess)
				.catch(saveUpdateDurationResourceError);
		}

		function saveUpdateDurationResourceError(reason) {
			$log.error('saveUpdateDurationResourceError:', reason);
		}

		function saveUpdateDurationResourceSuccess(response) {
			$log.log('saveUpdateDurationResourceSuccess:', response);
			gotoOverview();
		}

		// Target Recurring Checkbox
		// -------------------------
		function saveUpdateRecurringCheckbox() {
			$log.info('saveUpdateRecurringCheckbox');
			vm.goal.target.update.target_id = vm.goal.target.id;
			var updateRecurringCheckboxResource = new UpdateRecurringCheckboxResourceFactory();
			updateRecurringCheckboxResource.update = vm.goal.target.update;
			updateRecurringCheckboxResource.$save()
				.then(saveUpdateRecurringCheckboxResourceSuccess)
				.catch(saveUpdateRecurringCheckboxResourceError);
		}

		function saveUpdateRecurringCheckboxResourceError(reason) {
			$log.error('saveUpdateRecurringCheckboxResourceError:', reason);
		}

		function saveUpdateRecurringCheckboxResourceSuccess(response) {
			$log.log('saveUpdateRecurringCheckboxResourceSuccess:', response);
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
	}

})();
