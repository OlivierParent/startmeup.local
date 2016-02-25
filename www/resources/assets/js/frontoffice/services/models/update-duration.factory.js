/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UpdateDurationModelFactory', UpdateDurationModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UpdateDurationModelFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'INCREMENT_TYPES'
	];

	function UpdateDurationModelFactory(
		// Angular
		$log,
		// Custom
		INCREMENT_TYPES
	) {
		/**
		 * Update Model of type duration. A target has updates.
		 *
		 * @param data
		 * @constructor
		 */
		function UpdateDuration(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// FK
			this.target_id = data.target_id || null;

			// Properties
			this.time_incrementation = data.time_incrementation || 0;

			// Properties omitted from JSON by Angular due to `$$` prefix.
			this.$$time_increment      = 0;
			this.$$time_incrementation = '';

			// Run on construct
			this.$$changeTimeIncrementation();
		}

		// Methods
		// =======
		UpdateDuration.prototype.$$changeTimeIncrementation = function () {
			$log.log('$$changeTimeIncrementation'
,				this.time_incrementation, this.$$time_increment
			);
			this.$$time_incrementation = this.time_incrementation * this.$$time_increment;
		};

		UpdateDuration.prototype.$$setTimeIncrement = function (time_increment) {
			var increment = _.find(INCREMENT_TYPES, function (item) {
				return item.value === time_increment;
			});

			this.$$time_increment = increment.minutes;
		};

		UpdateDuration.prototype.$$timeDecrement = function (event) {
			event.preventDefault();

			var min = 0;
			if (min < this.time_incrementation) {
				this.time_incrementation--;
			} else {
				this.time_incrementation = min;
			}
			this.$$changeTimeIncrementation();
		};

		UpdateDuration.prototype.$$timeIncrement = function (event) {
			event.preventDefault();

			var max = 200;
			if (this.time_incrementation < max) {
				this.time_incrementation++;
			} else {
				this.time_incrementation = max;
			}
			this.$$changeTimeIncrementation();
		};

		return UpdateDuration;
	}

})();
