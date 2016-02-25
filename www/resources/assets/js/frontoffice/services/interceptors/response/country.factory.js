/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('CountryResponseInterceptorFactory', CountryResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	CountryResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'CountryModelFactory'
	];

	function CountryResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		CountryModelFactory
	) {
		function interceptor(response) {
			//$log.info('CountryResponseInterceptor:', response);
			if (angular.isArray(response.data)) {
				response.resource = response.data.map(transformToModel);
			} else {
				response.resource = transformToModel(response.data);
			}

			return response;
		}

		function transformToModel(data) {
			return new CountryModelFactory(data);
		}

		return interceptor;
	}

})();
