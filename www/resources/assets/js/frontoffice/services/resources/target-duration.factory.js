/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('TargetDurationResourceFactory', TargetDurationResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	TargetDurationResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'TargetDurationResponseInterceptorFactory',
		'UriFactory'
	];

	function TargetDurationResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		TargetDurationResponseInterceptorFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('targets/duration/:targetDurationId');

		var paramDefaults = {
			targetDurationId: '@id'
		};

		var actions = {
			'update': {
				interceptor: {
					response: TargetDurationResponseInterceptorFactory
				},
				isArray: false,
				method: 'PUT',
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
