/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('LocalityResourceFactory', LocalityResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	LocalityResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'LocalityResponseInterceptorFactory',
		'UriFactory'
	];

	function LocalityResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		LocalityResponseInterceptorFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('localities/:localityId');

		var paramDefaults = {
			localityId: '@id'
		};

		var actions = {
			'getWithRegion': {
				interceptor: {
					response: LocalityResponseInterceptorFactory
				},
				method: 'GET',
				params: {
					'include[]': 'region'
				}
			},
			'getWithCountry': {
				interceptor: {
					response: LocalityResponseInterceptorFactory
				},
				method: 'GET',
				params: {
					'include[]': 'region.country'
				}
			},
			'query': {
				interceptor: {
					response: LocalityResponseInterceptorFactory
				},
				isArray: true,
				method: 'GET',
				transformResponse: GenericResponseTransformerFactory
			},
			'queryWithRegion': {
				interceptor: {
					response: LocalityResponseInterceptorFactory
				},
				isArray: true,
				method: 'GET',
				params: {
					'include[]': 'region'
				},
				transformResponse: GenericResponseTransformerFactory
			},
			'queryWithCountry': {
				interceptor: {
					response: LocalityResponseInterceptorFactory
				},
				isArray: true,
				method: 'GET',
				params: {
					'include[]': 'region.country'
				},
				transformResponse: GenericResponseTransformerFactory
			},
			'save': {
				isArray: false,
				method: 'POST',
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
