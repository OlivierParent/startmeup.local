/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UserMoodResourceFactory', UserMoodResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UserMoodResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'MoodResponseInterceptorFactory',
		'UriFactory'
	];

	function UserMoodResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		MoodResponseInterceptorFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('users/:userId/moods/:moodId');

		var paramDefaults = {
			userId: '@id',
			moodId: '@id'
		};

		var actions = {
			'save': {
				isArray: false,
				method: 'POST',
				transformResponse: GenericResponseTransformerFactory
			},
			'statistics': {
				interceptor: {
					response: MoodResponseInterceptorFactory
				},
				isArray: true,
				method: 'GET',
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
