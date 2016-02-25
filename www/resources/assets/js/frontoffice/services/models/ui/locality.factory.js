/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('LocalityUiModelFactory', LocalityUiModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	LocalityUiModelFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'LocalityModelFactory',
		'LocalityResourceFactory'
	];

	function LocalityUiModelFactory(
		// Angular
		$log,
		// Custom
		LocalityModelFactory,
		LocalityResourceFactory
	) {
		/**
		 * Locality Model for use in the User Interface only.
		 *
		 * @constructor
		 */
		function Locality() {
			// Properties omitted from JSON by Angular due to `$$` prefix.
			this.$$searchTextName       = null;
			this.$$searchTextPostalCode = null;
			this.$$selected             = null;
		}

		// Methods
		// =======
		//Locality.prototype.$$changeByName = function () {
		//	$log.log('$$changeByName');
		//	var self = this;
		//	this.$$searchByName()
		//		.$promise
		//		.then(function (results) {
		//			$log.log('$$changeByName results:', results);
		//			if (results.data.length < 1) {
		//				var data = {
		//					name       : self.$$searchTextName,
		//					postal_code: self.$$searchTextPostalCode
		//				};
		//				self.$$selected = self.$$createModel(data);
		//			}
		//		});
		//};

		//Locality.prototype.$$changeByPostalCode = function () {
		//	$log.log('$$changeByPostalCode');
		//	var self = this;
		//	this.$$searchByPostalCode()
		//		.$promise
		//		.then(function (results) {
		//			$log.log('$$changeByPostalCode results:', results);
		//			if (results.data.length < 1) {
		//				var data = {
		//					name       : self.$$searchTextName,
		//					postal_code: self.$$searchTextPostalCode
		//				};
		//				self.$$selected = self.$$createModel(data);
		//			}
		//		});
		//};

		Locality.prototype.$$createModel = function (data) {
			$log.log('$$createModel Locality with:', data);

			return new LocalityModelFactory(data);
		};

		Locality.prototype.$$searchByName = function () {
			var params = {
				'filter[name]': this.$$searchTextName
			};

			return LocalityResourceFactory
				.queryWithCountry(params);
		};

		Locality.prototype.$$searchByPostalCode = function () {
			var params = {
				'filter[postal_code]': this.$$searchTextPostalCode
			};

			return LocalityResourceFactory
				.queryWithCountry(params);
		};

		return Locality;
	}

})();
