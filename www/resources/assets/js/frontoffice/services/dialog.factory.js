/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('DialogFactory', DialogFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	DialogFactory.$inject = [
		// Angular Material Design
		'$mdDialog',
		// Custom
		'UriFactory'
	];

	function DialogFactory(
		// Angular Material Design
		$mdDialog,
		// Custom
		UriFactory
	) {
		function show(title, message) {
			var config = {
				bindToController: true,
				controller: 'DialogCtrl',
				controllerAs: 'vm',
				locals: {
					messages: message,
					title  : title
				},
				templateUrl: UriFactory.getDialog('message')

			};

			return $mdDialog.show(config);
		}

		function showItems(title, items) {
			var config = {
				bindToController: true,
				controller: 'DialogCtrl',
				controllerAs: 'vm',
				locals: {
					items: items,
					title: title
				},
				templateUrl: UriFactory.getDialog('items')

			};

			return $mdDialog.show(config);
		}

		return {
			show     : show,
			showItems: showItems
		};

	}

})();
