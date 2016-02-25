/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('CompanyResourceFactory', CompanyResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	CompanyResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'UriFactory'
	];

	function CompanyResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('companies/:companyId');

		var paramDefaults = {
			companyId: '@id'
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
