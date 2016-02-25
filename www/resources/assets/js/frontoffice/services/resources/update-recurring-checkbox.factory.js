/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UpdateRecurringCheckboxResourceFactory', UpdateRecurringCheckboxResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UpdateRecurringCheckboxResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'UriFactory'
	];

	function UpdateRecurringCheckboxResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('updates/recurringcheckbox/:updateRecurringCheckboxId');

		var paramDefaults = {
			updateRecurringCheckboxId: '@id'
		};

		var actions = {
			'save': {
				isArray: false,
				method: 'POST',
				transformResponse: GenericResponseTransformerFactory
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
