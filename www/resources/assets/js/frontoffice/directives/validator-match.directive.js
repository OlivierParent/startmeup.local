/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () {
	'use strict';

	angular.module('smuDirectives')
		.directive('smuMatchModel', smuMatchModel);

	// Inject dependencies into constructor (needed when JS minification is applied).
	smuMatchModel.$inject = [
		// Angular
		'$parse'
	];

	function smuMatchModel(
		// Angular
		$parse
	) {

		return {
			require: '^ngModel', // ngModel is required
			restrict: 'A',       // Attribute directive only
			link: function (scope, element, attrs, NgModelController) {

				var targetFunction = $parse(attrs.smuMatchModel);
				function targetValue() {
					return targetFunction(scope);
				}

				// Add new validator
				NgModelController.$validators.smuMatchModel = function () {
					return NgModelController.$viewValue === targetValue();
				};

				// Run all validators when targetValue changes.
				scope.$watch(targetValue, function () {
					NgModelController.$$parseAndValidate();
				});

			}

		};

	}

})();
