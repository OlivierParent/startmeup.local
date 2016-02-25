/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('TargetRecurringCheckboxResourceFactory', TargetRecurringCheckboxResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	TargetRecurringCheckboxResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'TargetRecurringCheckboxResponseInterceptorFactory',
		'UriFactory'
	];

	function TargetRecurringCheckboxResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		TargetRecurringCheckboxResponseInterceptorFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('targets/recurringcheckbox/:targetRecurringCheckboxId');

		var paramDefaults = {
			targetRecurringCheckboxId: '@id'
		};

		var actions = {
			'update': {
				interceptor: {
					response: TargetRecurringCheckboxResponseInterceptorFactory
				},
				isArray: false,
				method: 'PUT',
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
