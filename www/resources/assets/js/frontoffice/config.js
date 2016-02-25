/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuApplication')
		.config(Config);

	// Inject dependencies into constructor (needed when JS minification is applied).
	Config.$inject = [
		// Angular
		'$compileProvider',
		'$resourceProvider',
		// Angular Material Design
		'$mdThemingProvider'
	];

	function Config(
		// Angular
		$compileProvider,
		$resourceProvider,
		// Angular Material Design
		$mdThemingProvider
	) {
		$compileProvider.debugInfoEnabled(true); // Set to `false` for production

		$resourceProvider.defaults.actions.query.isArray = false; // Allow { 'data': [ … ] } rather than [ … ]
		//console.info($resourceProvider.defaults.actions);

		// @link: http://www.google.com/design/spec/style/color.html
		$mdThemingProvider.theme('default').
			primaryPalette('brown', {
				'default':  '50',
				'hue-1':    '50',
				'hue-2':   '600',
				'hue-3':  'A100'
			}).
			accentPalette('teal', {
				'default': '500',
				'hue-1':    '50',
				'hue-2':   '600',
				'hue-3':  'A100'
			}).
			warnPalette('red');
	}

})();
