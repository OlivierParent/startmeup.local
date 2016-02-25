/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('GoalResponseInterceptorFactory', GoalResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	GoalResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'GoalModelFactory'
	];

	function GoalResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		GoalModelFactory
	) {
		function interceptor(response) {
			//$log.info('GoalResponseInterceptor:', response);
			if (angular.isArray(response.data)) {
				response.resource = response.data.map(transformToModel);
			} else {
				response.resource = transformToModel(response.data);
			}

			return response;
		}

		function transformToModel(data) {
			return new GoalModelFactory(data);
		}

		return interceptor;
	}

})();
