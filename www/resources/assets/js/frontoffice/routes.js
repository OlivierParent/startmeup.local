/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuApplication')
		.config(Routes)
		.run(Preloads);

	// Routes
	// ------
	// Inject dependencies into constructor (needed when JS minification is applied).
	Routes.$inject = [
		// Angular
		'$routeProvider'
	];

	function Routes(
		// Angular
		$routeProvider
	) {
		$routeProvider
			// Gamification
			.when('/gamification', {
				templateUrl: _getView('gamification/shoot')
			})
			.when('/gamification/leaderboard', {
				templateUrl: _getView('gamification/leaderboard')
			})
			.when('/gamification/trophies', {
				templateUrl: _getView('gamification/trophies')
			})

			// Goals
			.when('/goals', {
				templateUrl: _getView('goals/goals-overview'),
				controller: 'GoalsCtrl',
				controllerAs: 'vm'
			})
			.when('/goals/category/:categoryId/edit', {
				templateUrl: _getView('goals/category-edit'),
				controller: 'CategoryEditCtrl',
				controllerAs: 'vm'
			})
			.when('/goals/category/create', {
				templateUrl: _getView('goals/category-create'),
				controller: 'CategoryCreateCtrl',
				controllerAs: 'vm'
			})
			.when('/goals/category/:categoryId/goal/create', {
				templateUrl: _getView('goals/goal-create'),
				controller: 'GoalCreateCtrl',
				controllerAs: 'vm'
			})
			.when('/goals/category/:categoryId/goal/:goalId/edit', {
				templateUrl: _getView('goals/goal-edit'),
				controller: 'GoalEditCtrl',
				controllerAs: 'vm'
			})
			.when('/goals/category/:categoryId/goal/:goalId/target/update/create', {
				templateUrl: _getView('goals/goal-update'),
				controller: 'GoalUpdateCtrl',
				controllerAs: 'vm'
			})
			.when('/goals/category/:categoryId/goal/:goalId/progress', {
				templateUrl: _getView('goals/goal-progress'),
				controller: 'GoalProgressCtrl',
				controllerAs: 'vm'
			})
			.when('/goals/in-progress', {
				templateUrl: _getView('goals/goals-in-progress'),
				controller: 'GoalsInProgressCtrl',
				controllerAs: 'vm'
			})
			.when('/goals/progress', {
				templateUrl: _getView('goals/goals-progress'),
				controller: 'GoalsProgressCtrl',
				controllerAs: 'vm'
			})

			// Moods
			.when('/moods', {
				templateUrl: _getView('moods/mood-update'),
				controller: 'MoodUpdateCtrl',
				controllerAs: 'vm'
			})
			.when('/moods/statistics', {
				templateUrl: _getView('moods/mood-statistics'),
				controller: 'MoodStatisticsCtrl',
				controllerAs: 'vm'
			})

			// Nearby
			.when('/nearby', {
				templateUrl: _getView('nearby/map'),
				controller: 'NearbyCtrl',
				controllerAs: 'vm'
			})

			// Registration
			.when('/registration/step/1/of/4', {
				templateUrl: _getView('registration/step-1-user-account'),
				controller: 'RegistrationStep1Ctrl',
				controllerAs: 'vm'
			})
			.when('/registration/step/2/of/4', {
				templateUrl: _getView('registration/step-2-personal-profile'),
				controller: 'RegistrationStep2Ctrl',
				controllerAs: 'vm'
			})
			.when('/registration/step/3/of/4', {
				templateUrl: _getView('registration/step-3-company-profile'),
				controller: 'RegistrationStep3Ctrl',
				controllerAs: 'vm'
			})
			.when('/registration/step/4/of/4', {
				templateUrl: _getView('registration/step-4-completed'),
				controller: 'RegistrationStep4Ctrl',
				controllerAs: 'vm'
			})

			// Settings
			.when('/settings', {
				templateUrl: _getView('settings/menu'),
				controller: 'SettingsCtrl',
				controllerAs: 'vm'
			})

			// Log In
			.when('/log-in', {
				templateUrl: _getView('log-in'),
				controller: 'LogInCtrl',
				controllerAs: 'vm'
			})

			// Splash Screen
			.when('/splash', {
				templateUrl: _getView('splash')
			})

			// Default
			.otherwise({
				redirectTo: '/splash'
			});
	}

	// Preload Templates
	// -----------------
	Preloads.$inject = [
		// Angular
		'$http',
		'$templateCache'
	];

	function Preloads(
		// Angular
		$http,
		$templateCache
	) {
		var partials = [
				'validation-messages'
			],
			views = [
				'registration/step-1-user-account',
				'registration/step-2-personal-profile',
				'registration/step-3-company-profile',
				'registration/step-4-completed'
			];

		partials.forEach(function (template) {
			$http.get(_getPartialView(template), { cache: $templateCache });
		});

		views.forEach(function (template) {
			$http.get(_getView(template), { cache: $templateCache });
		});
	}

	/**
	 *
	 * @param uri
	 * @returns {string}
	 * @private
	 */
	function _getPartialView(uri) {
		return '/templates/' + uri + '.partial.html';
	}

	/**
	 *
	 * @param uri
	 * @returns {string}
	 * @private
	 */
	function _getView(uri) {
		return '/templates/' + uri + '.view.html';
	}

})();
