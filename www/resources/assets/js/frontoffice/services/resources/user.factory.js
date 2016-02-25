/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UserResourceFactory', UserResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UserResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'UriFactory',
		'UserResponseInterceptorFactory'
	];

	function UserResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		UriFactory,
		UserResponseInterceptorFactory
	) {
		var url = UriFactory.getApi('users/:userId');

		var paramDefaults = {
			userId: '@id'
		};

		var actions = {
			'get': {
				interceptor: {
					response: UserResponseInterceptorFactory
				},
				isArray: false,
				method: 'GET',
				transformResponse: GenericResponseTransformerFactory
			},
			'save': {
				isArray: false,
				method: 'POST',
				transformResponse: GenericResponseTransformerFactory
			},
			'update': {
				interceptor: {
					response: UserResponseInterceptorFactory
				},
				isArray: false,
				method: 'PUT',
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
