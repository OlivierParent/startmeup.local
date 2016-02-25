/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('RegionResourceFactory', RegionResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	RegionResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'RegionResponseInterceptorFactory',
		'UriFactory'
	];

	function RegionResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		RegionResponseInterceptorFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('regions/:regionId');

		var paramDefaults = {
			regionId: '@id'
		};

		var actions = {
			'getWithCountry': {
				method: 'GET',
				params: {
					'include[]': 'country'
				}
			},
			'query': {
				interceptor: {
					response: RegionResponseInterceptorFactory
				},
				isArray: true,
				method: 'GET',
				transformResponse: GenericResponseTransformerFactory
			},
			'queryWithCountry': {
				interceptor: {
					response: RegionResponseInterceptorFactory
				},
				isArray: true,
				method: 'GET',
				params: {
					'include[]': 'country'
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
