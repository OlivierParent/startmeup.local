/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('GoalModelFactory', GoalModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	GoalModelFactory.$inject = [
		// Angular
		'$log',
		// Constants
		'TARGET_TYPES',
		// Custom
		'TargetCheckboxModelFactory',
		'TargetDurationModelFactory',
		'TargetRecurringCheckboxModelFactory'
	];

	function GoalModelFactory(
		// Angular
		$log,
		// Constants
		TARGET_TYPES,
		// Custom
		TargetCheckboxModelFactory,
		TargetDurationModelFactory,
		TargetRecurringCheckboxModelFactory
	) {
		// Note: Angular hides properties prefixed with `$$` when converting to JSON
		/**
		 * Goal Model.
		 *
		 * @param data
		 * @constructor
		 */
		function Goal(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// FK
			this.user_id     = data.user_id || null;
			this.category_id = data.category_id || null;

			// Properties
			this.name         = data.name || null;
			this.notes        = data.notes || null;
			this.in_progress  = data.in_progress || null;
			this.target       = null;
			this.target_class = null;

			// Run on construction
			this.$$addTarget(data.target_class, data.target);
		}

		// Methods
		// =======
		Goal.prototype.$$addTarget = function(targetClass, target) {
			switch (targetClass) {
				case TARGET_TYPES.a_Checkbox.value:
					this.$$addTargetCheckbox(target);
					break;
				case TARGET_TYPES.b_RecurringCheckbox.value:
					this.$$addTargetRecurringCheckbox(target);
					break;
				case TARGET_TYPES.c_Duration.value:
					this.$$addTargetDuration(target);
					break;
				default:
					$log.error('Unknown Target Class: ' + targetClass);
					break;
			}
		};

		Goal.prototype.$$addTargetCheckbox = function (target) {
			this.target = new TargetCheckboxModelFactory(target);
			this.target_class = TARGET_TYPES.a_Checkbox.value;
		};

		Goal.prototype.$$addTargetRecurringCheckbox = function (target) {
			this.target = new TargetRecurringCheckboxModelFactory(target);
			this.target_class = TARGET_TYPES.b_RecurringCheckbox.value;
		};

		Goal.prototype.$$addTargetDuration = function (target) {
			this.target = new TargetDurationModelFactory(target);
			this.target_class = TARGET_TYPES.c_Duration.value;
		};

		Goal.prototype.$$hasTargetTypeCheckbox = function () {
			return this.target_class === TARGET_TYPES.a_Checkbox.value;
		};

		Goal.prototype.$$hasTargetTypeRecurringCheckbox = function () {
			return this.target_class === TARGET_TYPES.b_RecurringCheckbox.value;
		};

		Goal.prototype.$$hasTargetTypeDuration = function () {
			return this.target_class === TARGET_TYPES.c_Duration.value;
		};

		return Goal;
	}

})();
