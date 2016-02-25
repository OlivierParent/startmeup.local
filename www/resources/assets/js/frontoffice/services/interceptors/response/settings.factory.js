/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('SettingsResponseInterceptorFactory', SettingsResponseInterceptorFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	SettingsResponseInterceptorFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'SettingsModelFactory'
	];

	function SettingsResponseInterceptorFactory(
		// Angular
		$log,
		// Custom
		SettingsModelFactory
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
			return new SettingsModelFactory(data);
		}

		return interceptor;
	}

})();
