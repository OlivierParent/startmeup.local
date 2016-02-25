/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('CategoryEditCtrl', CategoryEditCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	CategoryEditCtrl.$inject = [
		// Angular
		'$log',
		// Custom
		'CategoryResourceFactory',
		'StorageFactory'
	];

	function CategoryEditCtrl(
		// Angular
		$log,
		// Custom
		CategoryResourceFactory,
		StorageFactory
	) {
		$log.info('CategoryEditCtrl');
		// ViewModel
		// =========
		var vm = this;

		// @todo Implement edit Category.

		// Functions
		// =========

	}

})();
