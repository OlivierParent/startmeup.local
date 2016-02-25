/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UserSettingsResourceFactory', UserSettingsResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UserSettingsResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'SettingsResponseInterceptorFactory',
		'UriFactory'
	];

	function UserSettingsResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		SettingsResponseInterceptorFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('users/:userId/settings/:settingsId');

		var paramDefaults = {
			userId    : '@id',
			settingsId: '@id'
		};

		var actions = {
			'get': {
				interceptor: {
					response: SettingsResponseInterceptorFactory
				},
				isArray: false,
				method: 'GET',
				transformResponse: GenericResponseTransformerFactory
			},
			'query': {
				interceptor: {
					response: SettingsResponseInterceptorFactory
				},
				isArray: true,
				method: 'GET',
				transformResponse: GenericResponseTransformerFactory
			},
			'queryLast': {
				interceptor: {
					response: SettingsResponseInterceptorFactory
				},
				isArray: true,
				method: 'GET',
				params: {
					'limit'   : 1,
					'sort[id]': 'desc'
				},
				transformResponse: GenericResponseTransformerFactory
			},
			'save': {
				isArray: false,
				method: 'POST',
				transformResponse: GenericResponseTransformerFactory
			},
			'update': {
				interceptor: {
					response: SettingsResponseInterceptorFactory
				},
				isArray: false,
				method: 'PUT',
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
