/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('ToastFactory', ToastFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	ToastFactory.$inject = [
		// Angular Material Design
		'$mdToast',
		// Custom
		'UriFactory'
	];

	function ToastFactory(
		// Angular Material Design
		$mdToast,
		// Custom
		UriFactory
	) {
		function show(message) {
			var config = {
				bindToController: true,
				controller: 'ToastCtrl',
				controllerAs: 'vm',
				//hideDelay: 3000,
				locals: {
					message: message
				},
				//position: 'bottom left',
				templateUrl: UriFactory.getToast('message')

			};

			return $mdToast.show(config);
		}

		function showSimple(message) {
			var toast = $mdToast
				.simple()
				.content(message);

			return $mdToast.show(toast);
		}

		return {
			show: show,
			showSimple: showSimple
		};

	}

})();
