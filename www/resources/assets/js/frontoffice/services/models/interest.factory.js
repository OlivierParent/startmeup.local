/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('InterestModelFactory', InterestModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	InterestModelFactory.$inject = [
		// Angular
		'$log'
	];

	function InterestModelFactory(
		// Angular
		$log
	) {
		/**
		 * Interest Model. A user has interests.
		 *
		 * @param data
		 * @constructor
		 */
		function Interest(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// Properties
			this.name = data.name || null;

			// Properties omitted from JSON by Angular due to `$$` prefix.
			this.$$name = angular.isDefined(data.name) ? angular.uppercase(data.name) : null; // Upper case name for searches.
		}

		// Methods
		// =======

		$log.log(Interest);

		return Interest;
	}

})();
