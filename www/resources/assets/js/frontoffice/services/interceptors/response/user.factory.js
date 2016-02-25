/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UserResponseInterceptorFactory', UserResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UserResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'UserModelFactory'
	];

	function UserResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		UserModelFactory
	) {
		function interceptor(response) {
			//$log.info('UserResponseInterceptor:', response);
			if (angular.isArray(response.data)) {
				response.resource = response.data.map(transformToModel);
			} else {
				response.resource = transformToModel(response.data);
			}

			return response;
		}

		function transformToModel(data) {
			return new UserModelFactory(data);
		}

		return interceptor;
	}

})();
