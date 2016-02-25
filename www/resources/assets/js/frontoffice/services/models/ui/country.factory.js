/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('CountryUiModelFactory', CountryUiModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	CountryUiModelFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'CountryModelFactory',
		'CountryResourceFactory'
	];

	function CountryUiModelFactory(
		// Angular
		$log,
		// Custom
		CountryModelFactory,
		CountryResourceFactory
	) {
		/**
		 * Country Model for use in the User Interface only.
		 *
		 * @constructor
		 */
		function Country() {
			// Properties omitted from JSON by Angular due to `$$` prefix.
			this.$$searchTextIso  = null;
			this.$$searchTextName = null;
			this.$$selected       = null;
		}

		// Methods
		// =======
		Country.prototype.$$createModel = function (data) {
			$log.log('$$createModel Country with:', data);

			return new CountryModelFactory(data);
		};

		Country.prototype.$$searchByIso = function () {
			var params = {
				'filter[iso]': this.$$searchTextIso
			};

			return CountryResourceFactory
				.query(params);
		};

		Country.prototype.$$searchByName = function () {
			var params = {
				'filter[name]': this.$$searchTextName
			};

			return CountryResourceFactory
				.query(params);
		};

		return Country;
	}

})();
