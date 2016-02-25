/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('CountryModelFactory', CountryModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	//CountryModelFactory.$inject = [];

	function CountryModelFactory() {
		/**
		 * Country Model.
		 *
		 * @param data
		 * @constructor
		 */
		function Country(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// Properties
			this.iso  = data.iso || null;
			this.name = data.name || null;
		}

		// Methods
		// =======

		return Country;
	}

})();
