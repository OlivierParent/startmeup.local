/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.css.outputFolder = 'styles/css'; // Override default 'css'
elixir.config.js.outputFolder  = 'scripts/js'; // Override default 'js'

var path = {
		base : './',
		bower: 'vendor/bower_components',
		css  : elixir.config.publicPath + '/' + elixir.config.css.outputFolder,
		fonts: elixir.config.publicPath + '/styles/fonts',
		js   : elixir.config.publicPath + '/' + elixir.config.js.outputFolder
	},
	vendor = {
		angular			: path.bower + '/angular/angular.js',
		angularModule	: {
			animate		: path.bower + '/angular-animate/angular-animate.js',
			aria		: path.bower + '/angular-aria/angular-aria.js',
			cookies		: path.bower + '/angular-cookies/angular-cookies.js',
			material	: path.bower + '/angular-material',
			messages	: path.bower + '/angular-messages/angular-messages.js',
			resource	: path.bower + '/angular-resource/angular-resource.js',
			route		: path.bower + '/angular-route/angular-route.js',
			new_router	: path.bower + '/angular-new-router/dist/router.es5.js',
			sanitize	: path.bower + '/angular-sanitize/angular-sanitize.js',
			touch		: path.bower + '/angular-touch/angular-touch.js'
		},
		bootstrap		: path.bower + '/bootstrap-sass-official/assets',
		chartjs			: path.bower + '/chartjs/Chart.min.js',
		fontawesome		: path.bower + '/fontawesome',
		jquery			: path.bower + '/jquery/dist',
		leaflet			: path.bower + '/leaflet/dist',
		lodash			: path.bower + '/lodash/dist/lodash.min.js',
		moment			: path.bower + '/moment/min/moment-with-locales.min.js'
	},
	options = {
		sass: {
			includePaths: [
				path.base + vendor.bootstrap   + '/stylesheets/',
				path.base + vendor.fontawesome + '/scss/'
			]
		}
	};

elixir(function (mix) {
	mix
		// AngularJS (https://angularjs.org) + AngularJS Modules
		.copy(
			vendor.angularModule.material + '/angular-material.css',
			path.css                      + '/angular.css'
		)
		.scripts([
				vendor.angular,
				vendor.angularModule.animate,
				vendor.angularModule.aria,
				vendor.angularModule.material + '/angular-material.js',
				vendor.angularModule.messages,
				//vendor.angularModule.new_router,
				vendor.angularModule.route,
				vendor.angularModule.resource
			],
			path.js + '/angular.js',
			path.base
		)

		// Chart.js (http://www.chartjs.org)
		.copy(
			vendor.chartjs,
			path.js + '/chart.js'
		)

		// Leaflet (http://leafletjs.com)
		.copy(
			vendor.leaflet + '/leaflet.css',
			path.css       + '/leaflet.css'
		)
		.copy(
			vendor.leaflet + '/leaflet.js',
			path.js        + '/leaflet.js'
		)

		// LoDash (https://lodash.com)
		.copy(
			vendor.lodash,
			path.js + '/lodash.js'
		)

		// Moment (http://momentjs.com)
		.copy(
			vendor.moment,
			path.js + '/moment.js'
		)

		// App
		.sass(
			'backoffice.scss',
			path.css + '/backoffice.css',
			options.sass
		)
		.sass(
			'frontoffice.scss',
			path.css + '/frontoffice.css',
			options.sass
		)
		.sass(
			'styleguide.scss',
			path.css + '/styleguide.css',
			options.sass
		)
		.copy(
			vendor.fontawesome + '/fonts',
			path.fonts
		)
		.copy(
			vendor.bootstrap + '/fonts/bootstrap',
			path.fonts
		)
		.copy(
			elixir.config.assetsPath + '/html',
			elixir.config.publicPath
		)
		.copy(
			elixir.config.assetsPath + '/images',
			elixir.config.publicPath + '/images'
		)
		.scripts([
				vendor.jquery    + '/jquery.js',
				vendor.bootstrap + '/javascripts/bootstrap.js'
			],
			path.js + '/backoffice.js',
			path.base
		)
		.scriptsIn(
			elixir.config.assetsPath + '/' + elixir.config.js.folder + '/frontoffice',
			path.js + '/frontoffice.js'
		)
		.scriptsIn(
			elixir.config.assetsPath + '/' + elixir.config.js.folder + '/styleguide',
			path.js  + '/styleguide.js'
		)
		//.phpUnit()
		//.phpSpec()
	;
});
