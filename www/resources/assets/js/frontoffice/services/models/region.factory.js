/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('RegionModelFactory', RegionModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	//RegionModelFactory.$inject = [];

	function RegionModelFactory() {
		/**
		 * Region Model. A locality belongs to a region and a region belongs to a country.
		 *
		 * @param data
		 * @constructor
		 */
		function Region(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// FK
			this.country_id = data.country_id || null;

			// Properties
			this.iso  = data.iso || null;
			this.name = data.name || null;
		}

		return Region;
	}

})();
