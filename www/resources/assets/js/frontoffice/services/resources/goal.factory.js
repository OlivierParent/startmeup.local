/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('GoalResourceFactory', GoalResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	GoalResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'GoalResponseInterceptorFactory',
		'UriFactory'
	];

	function GoalResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		GoalResponseInterceptorFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('goals/:goalId');

		var paramDefaults = {
			goalId: '@id'
		};

		var actions = {
			'update': {
				interceptor: {
					response: GoalResponseInterceptorFactory
				},
				isArray: false,
				method: 'PUT',
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
