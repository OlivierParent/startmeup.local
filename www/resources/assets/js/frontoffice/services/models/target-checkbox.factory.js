/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('TargetCheckboxModelFactory', TargetCheckboxModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	TargetCheckboxModelFactory.$inject = [
		// Angular
		'$log'
	];

	function TargetCheckboxModelFactory(
		// Angular
		$log
	) {
		/**
		 * Target Model of type checkbox. A goal has a target.
		 *
		 * @param data
		 * @constructor
		 */
		function TargetCheckbox(data) {
			data = data || {};

			moment.locale('en'); // Moment.js

			// PK
			this.id = data.id || null;

			// Properties
			this.deadline_date     = data.deadline_date || null;
			this.deadline_time     = data.deadline_time || null;
			this.deadline_reminder = data.deadline_reminder || false;
			this.achieved_at       = data.achieved_at || null;

			// Properties omitted from JSON by Angular due to `$$` prefix.
			this.$$deadline_date = this.$$convertDate(data.deadline_date);
			this.$$deadline_time = this.$$convertTime(data.deadline_time);
			this.$$achieved_at   = data.achieved_at ? true : null;
		}

		// Methods
		// =======
		TargetCheckbox.prototype.$$changedAchievedAt = function () {
			$log.log('changed:', this.$$achieved_at);
			this.achieved_at = this.$$achieved_at ? moment().format('YYYY-MM-DD HH:mm:ss') : null;
		};

		TargetCheckbox.prototype.$$convertDate = function (dateString) {
			if (angular.isDefined(dateString) && dateString !== null) {
				return moment(dateString).toDate();
			} else {
				return null;
			}
		};

		TargetCheckbox.prototype.$$convertTime = function (timeString) {
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

		TargetCheckbox.prototype.$$getSetDeadlineDate = function (newValue) {
			if (arguments.length) {
				this.deadline_date = moment(newValue).format('YYYY-MM-DD');
				return this.$$deadline_date = newValue;
			} else {
				return this.$$deadline_date;
			}
		};

		TargetCheckbox.prototype.$$getSetDeadlineTime = function (newValue) {
			if (arguments.length) {
				this.deadline_time = moment(newValue).format('HH:mm:ss');
				return this.$$deadline_time = newValue;
			} else {
				return this.$$deadline_time;
			}
		};

		return TargetCheckbox;
	}

})();
