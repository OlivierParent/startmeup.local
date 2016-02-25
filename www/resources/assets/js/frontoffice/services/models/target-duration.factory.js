/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('TargetDurationModelFactory', TargetDurationModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	TargetDurationModelFactory.$inject = [
		// Angular
		'$filter',
		'$log',
		// Custom
		'INCREMENT_TYPES',
		'UpdateDurationModelFactory'
	];

	function TargetDurationModelFactory(
		// Angular
		$filter,
		$log,
		// Custom
		INCREMENT_TYPES,
		UpdateDurationModelFactory
	) {
		/**
		 * Target Model of type duration. A goal has a target.
		 *
		 * @param data
		 * @constructor
		 */
		function TargetDuration(data) {
			data = data || {};

			moment.locale('en'); // Moment.js

			// PK
			this.id = data.id || null;

			// FK
			this.update = data.update || null;

			// Properties
			this.time_estimated = data.time_estimated || null;
			this.time_increment = data.time_increment || null;

			// Properties omitted from JSON by Angular due to `$$` prefix.
			this.$$duration       = null;
			this.$$time_increment = 0;

			// Run on construction
			this.$$addUpdate();
			this.$$updateDuration();
		}

		// Methods
		// =======
		TargetDuration.prototype.$$addUpdate = function () {
			if (!angular.isObject(this.update)) {
				this.update = new UpdateDurationModelFactory();
			}
		};

		TargetDuration.prototype.$$setTimeIncrement = function (time_increment) {
			var increment = _.find(INCREMENT_TYPES, function (item) {
				return item.value === time_increment;
			});

			this.$$time_increment = increment.minutes;
		};

		TargetDuration.prototype.$$updateDuration = function () {
			if (angular.isNumber(this.time_estimated) && angular.isString(this.time_increment)) {
				this.$$setTimeIncrement(this.time_increment);

				var minutes = this.time_estimated * this.$$time_increment;
				var duration = moment.duration(minutes, 'minutes');
				if (minutes < 60) {
					this.$$duration  = duration.asMinutes() + ' minutes';
				} else
				if (minutes < 240) {
					this.$$duration  = duration.asHours();
					this.$$duration += (duration === 1) ? ' hour' : ' hours';
				} else {
					this.$$duration = (duration.asDays() === 1) ? duration.asDays() + ' day' : $filter('number')(duration.asDays(), 2) + ' days';
				}
			} else {
				this.$$duration = null;
			}
		};

		return TargetDuration;
	}

})();
