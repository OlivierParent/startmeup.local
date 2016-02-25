/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('InterestResponseInterceptorFactory', InterestResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	InterestResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'InterestModelFactory'
	];

	function InterestResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		InterestModelFactory
	) {
		function interceptor(response) {
			//$log.info('InterestResponseInterceptor:', response);
			if (angular.isArray(response.data)) {
				response.resource = response.data.map(transformToModel);
			} else {
				response.resource = transformToModel(response.data);
			}

			return response;
		}

		function transformToModel(data) {
			return new InterestModelFactory(data);
		}

		return interceptor;
	}

})();
