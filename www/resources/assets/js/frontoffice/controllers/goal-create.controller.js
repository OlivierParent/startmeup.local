/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('GoalCreateCtrl', GoalCreateCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	GoalCreateCtrl.$inject = [
		// Angular
		'$log',
		'$routeParams',
		'$scope',
		'$window',
		// Constants
		'INCREMENT_TYPES',
		'REPEAT_TYPES',
		'TARGET_TYPES',
		// Custom
		'CategoryModelFactory',
		'DialogFactory',
		'GoalModelFactory',
		'GoalResourceFactory',
		'StorageFactory'
	];

	function GoalCreateCtrl(
		// Angular
		$log,
		$routeParams,
		$scope,
		$window,
		// Constants
		INCREMENT_TYPES,
		REPEAT_TYPES,
		TARGET_TYPES,
		// Custom
		CategoryModelFactory,
		DialogFactory,
		GoalModelFactory,
		GoalResourceFactory,
		StorageFactory
	) {
		$log.info('GoalCreateCtrl');
		// ViewModel
		// =========
		var vm = this;

		vm.category = new CategoryModelFactory({ id: $routeParams.categoryId })
		vm.goal     = new GoalModelFactory();
		vm.user     = StorageFactory.Local.getUserModel('user');

		// User Interface variables
		vm.$$INCREMENT_TYPES = INCREMENT_TYPES;
		vm.$$REPEAT_TYPES    = REPEAT_TYPES;
		vm.$$TARGET_TYPES    = TARGET_TYPES;

		vm.save = save;

		// Watchers
		// --------
		$scope.$watch('vm.goal.target_class'         , watchTargetClassHandler);
		$scope.$watch('vm.goal.target.time_estimated', watchTargetDurationHandler);
		$scope.$watch('vm.goal.target.time_increment', watchTargetDurationHandler);

		// Functions
		// =========
		function save(event) {
			event.preventDefault();

			vm.goal.user_id     = vm.user.id;
			vm.goal.category_id = vm.category.id;

			$log.info(vm.goal);

			saveGoal();
		}

		// Goal
		// ----
		function saveGoal() {
			var goalResource = new GoalResourceFactory();
			goalResource.goal = vm.goal;
			goalResource.$save()
				.then(saveGoalResourceSuccess)
				.catch(saveGoalResourceError);
		}

		function saveGoalResourceError(reason) {
			$log.error('saveGoalResourceError:', reason);
			DialogFactory
				.showItems('The goal could not be saved!', reason.errors);
		}

		function saveGoalResourceSuccess(response) {
			$log.log('saveGoalResourceSuccess:', response);
			$window.location.href = '#/goals';
		}

		// Watch Handlers
		// --------------
		function watchTargetClassHandler(newValue) {
			vm.goal.$$addTarget(newValue);
		}

		function watchTargetDurationHandler() {
			if (vm.goal.$$hasTargetTypeDuration()) {
				vm.goal.target.$$updateDuration();
			}
		}
	}

})();
