/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('CountryResourceFactory', CountryResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	CountryResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'CountryResponseInterceptorFactory',
		'GenericResponseTransformerFactory',
		'UriFactory'
	];

	function CountryResourceFactory(
		// Angular
		$resource,
		// Custom
		CountryResponseInterceptorFactory,
		GenericResponseTransformerFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('countries/:countryId');

		var paramDefaults = {
			countryId: '@id'
		};

		var actions = {
			'query': {
				interceptor: {
					response: CountryResponseInterceptorFactory
				},
				isArray: true,
				method: 'GET',
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
