/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('InterestResourceFactory', InterestResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	InterestResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'InterestResponseInterceptorFactory',
		'UriFactory'
	];

	function InterestResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		InterestResponseInterceptorFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('interests/:interestId');

		var paramDefaults = {
			interestId: '@id'
		};

		var actions = {
			query: {
				interceptor: {
					response: InterestResponseInterceptorFactory
				},
				isArray: true,
				method: 'GET',
				transformResponse: [GenericResponseTransformerFactory]
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
