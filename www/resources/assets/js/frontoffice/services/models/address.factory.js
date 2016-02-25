/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('AddressModelFactory', AddressModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	AddressModelFactory.$inject = [
		// Custom
		//'CountryModelFactory'
	];

	function AddressModelFactory(
		// Custom
		//CountryModelFactory
	) {
		/**
		 * Address Model.
		 *
		 * @param data
		 * @constructor
		 */
		function Address(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// FK
			this.locality_id = data.locality_id || null;
			//this.country = null;

			// Properties
			this.street   = data.street || null;
			this.extended = data.extended || null;

			// Properties omitted from JSON by Angular due to `$$` prefix.
		}

		// Methods
		// =======

		return Address;
	}

})();
