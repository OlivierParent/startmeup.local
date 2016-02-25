/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('MoodUpdateCtrl', MoodUpdateCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	MoodUpdateCtrl.$inject = [
		// Angular
		'$log',
		'$window',
		// Constants
		'MOOD_TYPES',
		// Custom
		'DialogFactory',
		'MoodModelFactory',
		'StorageFactory',
		'ToastFactory',
		'UserMoodResourceFactory'
	];

	function MoodUpdateCtrl(
		// Angular
		$log,
		$window,
		// Constants
		MOOD_TYPES,
		// Custom
		DialogFactory,
		MoodModelFactory,
		StorageFactory,
		ToastFactory,
		UserMoodResourceFactory
	) {
		$log.info('MoodUpdateCtrl');
		// ViewModel
		// =========
		var vm = this;

		vm.user         = StorageFactory.Local.getUserModel('user');
		vm.mood         = new MoodModelFactory();
		vm.mood.user_id = vm.user.id;

		vm.$$MOOD_TYPES = MOOD_TYPES;

		vm.save = save;

		$log.log('vm.mood:', vm.mood);

		// Functions
		// =========
		function gotoOverview() {
			$window.location.href = '#/goals';
		}

		function save(event) {
			event.preventDefault();

			var params = {
				userId: vm.user.id
			};
			var userMoodResource = new UserMoodResourceFactory();
			userMoodResource.mood = vm.mood;
			userMoodResource.$save(params)
				.then(saveUserMoodResourceResourceSuccess)
				.catch(saveUserMoodResourceResourceError);
		}

		// Response Handlers
		// -----------------
		function saveUserMoodResourceResourceError(reason) {
			$log.error('saveUserResourceError:', reason);
			DialogFactory
				.showItems('The user mood could not be saved!', reason.errors);
		}

		function saveUserMoodResourceResourceSuccess(response) {
			$log.log('saveUserResourceSuccess:', response);
			vm.mood.id = response.id;
			ToastFactory
				.show('User mood saved!')
				.finally(gotoOverview);
		}
	}

})();
