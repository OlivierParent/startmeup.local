/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('StatisticResourceFactory', StatisticResourceFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	StatisticResourceFactory.$inject = [
		// Angular
		'$resource',
		// Custom
		'UriFactory'
	];

	function StatisticResourceFactory(
		// Angular
		$resource,
		// Custom
		UriFactory
	) {
		var url = UriFactory.getApi('statistics/:statisticId');

		var paramDefaults = {
			statisticId: '@id'
		};

		var actions = {};

		return $resource(url, paramDefaults, actions);
	}

})();
