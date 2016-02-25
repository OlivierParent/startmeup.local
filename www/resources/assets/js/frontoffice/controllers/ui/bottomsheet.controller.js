/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('BottomSheetCtrl', BottomSheetCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	BottomSheetCtrl.$inject = [
		'$scope',
		'$mdBottomSheet'
	];

	function BottomSheetCtrl(
		$scope,
		$mdBottomSheet
	) {

		$scope.items = [
			{ name: 'Hangout', icon: 'hangout' },
			{ name: 'Mail', icon: 'mail' },
			{ name: 'Message', icon: 'message' },
			{ name: 'Copy', icon: 'copy' },
			{ name: 'Facebook', icon: 'facebook' },
			{ name: 'Twitter', icon: 'twitter' },
		];
		$scope.listItemClick = function($index) {
			var clickedItem = $scope.items[$index];
			//$mdBottomSheet.hide(clickedItem);
		};

	}

})();
