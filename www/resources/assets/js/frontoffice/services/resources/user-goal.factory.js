/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UserGoalResourceFactory', UserGoalResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UserGoalResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'GoalResponseInterceptorFactory',
		'UriFactory'
	];

	function UserGoalResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		GoalResponseInterceptorFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('users/:userId/goals/:goalId');

		var paramDefaults = {
			userId: '@id',
			goalId: '@id'
		};

		var actions = {
			'getWithTarget'  : {
				interceptor: {
					response: GoalResponseInterceptorFactory
				},
				method: 'GET',
				params: {
					'include[]': 'target'
				},
				transformResponse: GenericResponseTransformerFactory
			},
			'queryInProgress': {
				isArray: true,
				method: 'GET',
				params: {
					'filter[in_progress]': true
				},
				transformResponse: GenericResponseTransformerFactory
			},
			'queryWithTarget': {
				interceptor: {
					response: GoalResponseInterceptorFactory
				},
				isArray: false,
				method: 'GET',
				params: {
					'include[]': 'target'
				},
				transformResponse: GenericResponseTransformerFactory
			},
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
