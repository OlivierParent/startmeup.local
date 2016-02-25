/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('AuthUserResourceFactory', AuthUserResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	AuthUserResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'UriFactory'
	];

	function AuthUserResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('auth');

		var paramDefaults = {};

		var actions = {
			'login': {
				isArray: false,
				method: 'POST',
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
