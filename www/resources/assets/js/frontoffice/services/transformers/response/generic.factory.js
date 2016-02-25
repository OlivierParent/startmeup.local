/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('GenericResponseTransformerFactory', GenericResponseTransformerFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	GenericResponseTransformerFactory.$inject = [
		// Angular
		'$log'
	];

	function GenericResponseTransformerFactory(
		// Angular
		$log
	) {
		/**
		 * Transform { "data": [{},{}] } to generic objects [{},{}]
		 *
		 * @param data
		 * @param headers
		 * @param status
		 * @returns {*}
		 */
		function transformer(data, headers, status) {
			//$log.info('GenericResponseTransformer:', data);
			var parsedData = angular.fromJson(data);

			if (angular.isDefined(parsedData.data)) {
				return parsedData.data;
			}

			if (angular.isDefined(parsedData.errors)) {
				return parsedData.errors;
			}

			$log.warn('Transformer could not find any transformable information!');
		}

		return transformer;
	}

})();
