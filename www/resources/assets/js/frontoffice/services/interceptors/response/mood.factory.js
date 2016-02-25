/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('MoodResponseInterceptorFactory', MoodResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	MoodResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'MoodModelFactory'
	];

	function MoodResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		MoodModelFactory
	) {
		function interceptor(response) {
			//$log.info('MoodResponseInterceptor:', response);
			if (angular.isArray(response.data)) {
				response.resource = response.data.map(transformToModel);
			} else {
				response.resource = transformToModel(response.data);
			}

			return response;
		}

		function transformToModel(data) {
			return new MoodModelFactory(data);
		}

		return interceptor;
	}

})();
