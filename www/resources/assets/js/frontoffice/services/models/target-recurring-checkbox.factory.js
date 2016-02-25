/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('TargetRecurringCheckboxModelFactory', TargetRecurringCheckboxModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	TargetRecurringCheckboxModelFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'UpdateRecurringCheckboxModelFactory'
	];

	function TargetRecurringCheckboxModelFactory(
		// Angular
		$log,
		// Custom
		UpdateRecurringCheckboxModelFactory
	) {
		/**
		 * Target Model of type recurring checkbox. A goal has a target.
		 *
		 * @param data
		 * @constructor
		 */
		function TargetRecurringCheckbox(data) {
			data = data || {};

			moment.locale('en'); // Moment.js

			// PK
			this.id = data.id || null;

			// FK
			this.update = data.update || null;

			// Properties
			this.deadline_date     = data.deadline_date || null;
			this.deadline_time     = data.deadline_time || null;
			this.deadline_reminder = data.deadline_reminder || false;
			this.repeat_deadline   = data.repeat_deadline || null;
			this.repeat_until_date = data.repeat_until_date || null;
			this.repeat_until_time = data.repeat_until_time || null;

			// Properties omitted from JSON by Angular due to `$$` prefix.
			this.$$deadline_date     = this.$$convertDate(data.deadline_date);
			this.$$deadline_time     = this.$$convertTime(data.deadline_time);
			this.$$repeat_until_date = this.$$convertDate(data.repeat_until_date);
			this.$$repeat_until_time = this.$$convertTime(data.repeat_until_time);

			// Run on construction
			this.$$addUpdate();
		}

		// Methods
		// =======
		TargetRecurringCheckbox.prototype.$$addUpdate = function () {
			if (!angular.isObject(this.update)) {
				this.update = new UpdateRecurringCheckboxModelFactory();
			}
		};

		TargetRecurringCheckbox.prototype.$$convertDate = function (dateString) {
			if (angular.isDefined(dateString) && dateString !== null) {
				return moment(dateString).toDate();
			} else {
				return null;
			}
		};

		TargetRecurringCheckbox.prototype.$$convertTime = function (timeString) {
			if (angular.isDefined(timeString) && timeString !== null) {
				var timeArray = timeString.split(':');
				var time = {
					hours      : timeArray[0],
					minute     : timeArray[1],
					second     : timeArray[2],
					millisecond: 0
				};

				return moment(time).toDate();
			} else {
				return null;
			}
		};

		TargetRecurringCheckbox.prototype.$$getSetDeadlineDate = function (newValue) {
			if (arguments.length) {
				this.deadline_date = moment(newValue).format('YYYY-MM-DD');
				return this.$$deadline_date = newValue;
			} else {
				return this.$$deadline_date;
			}
		};

		TargetRecurringCheckbox.prototype.$$getSetDeadlineTime = function (newValue) {
			if (arguments.length) {
				this.deadline_time = moment(newValue).format('HH:mm:ss');
				return this.$$deadline_time = newValue;
			} else {
				return this.$$deadline_time;
			}
		};

		TargetRecurringCheckbox.prototype.$$getSetRepeatUntilDate = function (newValue) {
			if (arguments.length) {
				this.repeat_until_date = moment(newValue).format('YYYY-MM-DD');
				return this.$$repeat_until_date = newValue;
			} else {
				return this.$$repeat_until_date;
			}
		};

		TargetRecurringCheckbox.prototype.$$getSetRepeatUntilTime = function (newValue) {
			if (arguments.length) {
				this.repeat_until_time = moment(newValue).format('HH:mm:ss');
				return this.$$repeat_until_time = newValue;
			} else {
				return this.$$repeat_until_time;
			}
		};

		return TargetRecurringCheckbox;
	}

})();
