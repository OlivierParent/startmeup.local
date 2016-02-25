/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('RegionResponseInterceptorFactory', RegionResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	RegionResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'RegionModelFactory'
	];

	function RegionResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		RegionModelFactory
	) {
		function interceptor(response) {
			//$log.info('RegionResponseInterceptor:', response);
			if (angular.isArray(response.data)) {
				response.resource = response.data.map(transformToModel);
			} else {
				response.resource = transformToModel(response.data);
			}

			return response;
		}

		function transformToModel(data) {
			return new RegionModelFactory(data);
		}

		return interceptor;
	}

})();
