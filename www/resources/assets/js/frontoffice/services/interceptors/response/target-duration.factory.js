/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('TargetDurationResponseInterceptorFactory', TargetDurationResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	TargetDurationResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'TargetDurationModelFactory'
	];

	function TargetDurationResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		TargetDurationModelFactory
	) {
		function interceptor(response) {
			//$log.info('TargetDurationResponseInterceptor:', response);
			if (angular.isArray(response.data)) {
				response.resource = response.data.map(transformToModel);
			} else {
				response.resource = transformToModel(response.data);
			}

			return response;
		}

		function transformToModel(data) {
			return new TargetDurationModelFactory(data);
		}

		return interceptor;
	}

})();
