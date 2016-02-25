/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UpdateRecurringCheckboxModelFactory', UpdateRecurringCheckboxModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UpdateRecurringCheckboxModelFactory.$inject = [
		// Angular
		'$log'
	];

	function UpdateRecurringCheckboxModelFactory(
		// Angular
		$log
	) {
		/**
		 * Update Model of type recurring checkbox. A target has updates.
		 *
		 * @param data
		 * @constructor
		 */
		function UpdateRecurringCheckbox(data) {
			data = data || {};

			moment.locale('en');

			// PK
			this.id = data.id || null;

			// FK
			this.target_id = data.target_id || null;

			// Properties
			this.achieved_at = data.achieved_at || null;

			// Properties omitted from JSON by Angular due to `$$` prefix.
			this.$$achieved_at = data.achieved_at ? true : null;
		}

		// Methods
		// =======
		UpdateRecurringCheckbox.prototype.$$changedAchievedAt = function () {
			$log.log('changed:', this.$$achieved_at);
			this.achieved_at = this.$$achieved_at ? moment().format('YYYY-MM-DD HH:mm:ss') : null;
		};

		return UpdateRecurringCheckbox;
	}

})();
