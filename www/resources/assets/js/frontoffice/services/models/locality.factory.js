/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('LocalityModelFactory', LocalityModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	//LocalityModelFactory.$inject = [];

	function LocalityModelFactory() {
		/**
		 * Locality Model. A locality is usually a city, village or municipality. An address has a locality and
		 * a locality belongs to a region.
		 *
		 * @param data
		 * @constructor
		 */
		function Locality(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// FK
			this.region_id = data.region_id || null;
			//this.country = null;

			// Properties
			this.postal_code  = data.postal_code || null;
			this.name = data.name || null;
		}

		// Methods
		// =======

		return Locality;
	}

})();
