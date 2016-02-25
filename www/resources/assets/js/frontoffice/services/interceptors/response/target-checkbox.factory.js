/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('TargetCheckboxResponseInterceptorFactory', TargetCheckboxResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	TargetCheckboxResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'TargetCheckboxModelFactory'
	];

	function TargetCheckboxResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		TargetCheckboxModelFactory
	) {
		function interceptor(response) {
			//$log.info('TargetCheckboxResponseInterceptor:', response);
			if (angular.isArray(response.data)) {
				response.resource = response.data.map(transformToModel);
			} else {
				response.resource = transformToModel(response.data);
			}

			return response;
		}

		function transformToModel(data) {
			return new TargetCheckboxModelFactory(data);
		}

		return interceptor;
	}

})();
