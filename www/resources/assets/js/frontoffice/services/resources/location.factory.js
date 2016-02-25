/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('LocationResourceFactory', LocationResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	LocationResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'UriFactory'
	];

	function LocationResourceFactory(
		// Angular
		$resource,
		// Custom
		UriFactory
	) {
		var url = UriFactory.getApi('locations/:locationId');

		var paramDefaults = {
			locationId: '@id'
		};

		var actions = {
			'getWithAddress': {
				method: 'GET',
				params: {
					'include[]': 'address'
				}
			},
			'queryWithAddress': {
				isArray: false,
				method: 'GET',
				params: {
					'include[]': 'address'
				}
			}
		};

		return $resource(url, paramDefaults, actions);
	}

})();
