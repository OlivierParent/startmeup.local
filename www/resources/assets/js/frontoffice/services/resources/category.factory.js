/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('CategoryResourceFactory', CategoryResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	CategoryResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'UriFactory'
	];

	function CategoryResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('categories/:categoryId');

		var paramDefaults = {
			categoryId: '@id'
		};

		var actions = {
			'queryWithGoals': {
				isArray: false,
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
