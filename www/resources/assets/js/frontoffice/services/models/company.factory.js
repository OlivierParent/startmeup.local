/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('CompanyModelFactory', CompanyModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	//CompanyModelFactory.$inject = [];

	function CompanyModelFactory() {
		/**
		 * Company Model.
		 *
		 * @param data
		 * @constructor
		 */
		function Company(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// Properties
			this.description = data.description || null;
			this.name        = data.name || null;
		}

		// Methods
		// =======

		return Company;
	}

})();
