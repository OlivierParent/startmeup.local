/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('LocalityResponseInterceptorFactory', LocalityResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	LocalityResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'LocalityModelFactory'
	];

	function LocalityResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		LocalityModelFactory
	) {
		function interceptor(response) {
			//$log.info('LocalityResponseInterceptor:', response);
			if (angular.isArray(response.data)) {
				response.resource = response.data.map(transformToModel);
			} else {
				response.resource = transformToModel(response.data);
			}

			return response;
		}

		function transformToModel(data) {
			return new LocalityModelFactory(data);
		}

		return interceptor;
	}

})();
