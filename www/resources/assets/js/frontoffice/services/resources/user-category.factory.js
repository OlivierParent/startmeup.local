/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UserCategoryResourceFactory', UserCategoryResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UserCategoryResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'UriFactory'
	];

	function UserCategoryResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		UriFactory
	) {

		var url = UriFactory.getApi('users/:userId/categories/:categoryId');

		var paramDefaults = {
			userId    : '@id',
			categoryId: '@id'
		};

		var actions = {
			'getWithGoals': {
				isArray: false,
				method: 'GET',
				params: {
					'include[]': 'goals'
				},
				transformResponse: GenericResponseTransformerFactory
			},
			'getWithTarget': {
				isArray: false,
				method: 'GET',
				params: {
					'include[]': 'goals.target'
				},
				transformResponse: GenericResponseTransformerFactory
			},
			'queryWithGoals': {
				isArray: true,
				method: 'GET',
				params: {
					'include[]': 'goals'
				},
				transformResponse: GenericResponseTransformerFactory
			},
			'queryWithGoalsInProgress': {
				isArray: true,
				method: 'GET',
				params: {
					'filter[goals.in_progress]': true
				},
				transformResponse: GenericResponseTransformerFactory
			},
			'queryWithTarget': {
				isArray: true,
				method: 'GET',
				params: {
					'include[]': 'goals.target'
				},
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
