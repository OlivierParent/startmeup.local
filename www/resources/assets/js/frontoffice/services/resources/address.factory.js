/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('AddressResourceFactory', AddressResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	AddressResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'GenericResponseTransformerFactory',
		'UriFactory'
	];

	function AddressResourceFactory(
		// Angular
		$resource,
		// Custom
		GenericResponseTransformerFactory,
		UriFactory
	) {
		var url = UriFactory.getApi('addresses/:addressId');

		var paramDefaults = {
			addressId: '@id'
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
