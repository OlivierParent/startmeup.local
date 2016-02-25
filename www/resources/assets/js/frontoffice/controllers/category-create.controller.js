/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('CategoryCreateCtrl', CategoryCreateCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	CategoryCreateCtrl.$inject = [
		// Angular
		'$log',
		// Custom
		'CategoryResourceFactory',
		'StorageFactory'
	];

	function CategoryCreateCtrl(
		// Angular
		$log,
		// Custom
		CategoryResourceFactory,
		StorageFactory
	) {
		$log.info('CategoryCreateCtrl');
		// ViewModel
		// =========
		var vm = this;

		// @todo Implement create Category.

		// Functions
		// =========

	}

})();
