/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('TargetRecurringCheckboxResponseInterceptorFactory', TargetRecurringCheckboxResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	TargetRecurringCheckboxResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'TargetRecurringCheckboxModelFactory'
	];

	function TargetRecurringCheckboxResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		TargetRecurringCheckboxModelFactory
	) {
		function interceptor(response) {
			//$log.info('TargetRecurringCheckboxResponseInterceptor:', response);
			if (angular.isArray(response.data)) {
				response.resource = response.data.map(transformToModel);
			} else {
				response.resource = transformToModel(response.data);
			}

			return response;
		}

		function transformToModel(data) {
			return new TargetRecurringCheckboxModelFactory(data);
		}

		return interceptor;
	}

})();
