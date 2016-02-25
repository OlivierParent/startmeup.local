/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('RegionUiModelFactory', RegionUiModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	RegionUiModelFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'RegionModelFactory',
		'RegionResourceFactory'
	];

	function RegionUiModelFactory(
		// Angular
		$log,
		// Custom
		RegionModelFactory,
		RegionResourceFactory
	) {
		/**
		 * Region Model for use in the User Interface only.
		 *
		 * @constructor
		 */
		function Region() {
			// Properties omitted from JSON by Angular due to `$$` prefix.
			this.$$searchTextIso  = null;
			this.$$searchTextName = null;
			this.$$selected       = null;
		}

		// Methods
		// =======
		Region.prototype.$$createModel = function (data) {
			$log.log('$$createModel Region with:', data);

			return new RegionModelFactory(data);
		};

		Region.prototype.$$searchByIso = function () {
			var params = {
				'filter[iso]': this.$$searchTextIso
			};

			return RegionResourceFactory
				.queryWithCountry(params);
		};

		Region.prototype.$$searchByName = function () {
			var params = {
				'filter[name]': this.$$searchTextName
			};

			return RegionResourceFactory
				.queryWithCountry(params);
		};

		return Region;
	}

})();
