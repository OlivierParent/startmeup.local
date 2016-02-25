/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('TargetCheckboxResourceFactory', TargetCheckboxResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	TargetCheckboxResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'TargetCheckboxResponseInterceptorFactory',
		'UriFactory'
	];

	function TargetCheckboxResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		TargetCheckboxResponseInterceptorFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('targets/checkbox/:targetCheckboxId');

		var paramDefaults = {
			targetCheckboxId: '@id'
		};

		var actions = {
			'update': {
				interceptor: {
					response: TargetCheckboxResponseInterceptorFactory
				},
				isArray: false,
				method: 'PUT',
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
