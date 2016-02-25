/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('MoodStatisticsCtrl', MoodStatisticsCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	MoodStatisticsCtrl.$inject = [
		// Angular
		'$log',
		// Configs
		'configChart',
		// Constants
		'MOOD_TYPES',
		// Custom
		'StorageFactory',
		'UserMoodResourceFactory'
	];

	function MoodStatisticsCtrl(
		// Angular
		$log,
		// Configs
		configChart,
		// Constants
		MOOD_TYPES,
		// Custom
		StorageFactory,
		UserMoodResourceFactory
	) {
		$log.info('MoodStatisticsCtrl');
		// ViewModel
		// =========
		var vm = this;

		vm.user = StorageFactory.Local.getUserModel('user');

		vm.$$moodCounts = _.map(MOOD_TYPES, function (mood) {
			mood.count = 0;
			return mood;
		});

		$log.log('vm.$$moodCounts', vm.$$moodCounts);

		loadMoodStatistics();

		// Functions
		// =========
		function loadMoodStatistics() {
			$log.info('loadMoodStatistics');
			var params = {
				'userId': vm.user.id,
				'moodId': 'statistics'
			};
			var statistics = UserMoodResourceFactory.statistics(params);

			statistics.$promise
				.then(loadMoodStatisticsResourceSuccess)
				.catch(loadMoodStatisticsResourceError);
		}

		function loadMoodStatisticsResourceError(reason) {
			$log.error('loadMoodStatisticsResourceError:', reason);
		}

		function loadMoodStatisticsResourceSuccess(response) {
			$log.log('loadMoodStatisticsResourceSuccess:', response);

			vm.$$moodCounts.map(function (mood) {
				var foundMood =_.find(response.data, function (dataMood) {
					return dataMood.feeling == mood.value;
				});
				if (foundMood) {
					mood.count = foundMood.count;
				}
			});

			drawChart();
		}

		// Response Handlers
		// -----------------
		function drawChart() {
			var ctx = document.getElementById("mood-chart-0").getContext("2d");

			var data = {
				labels: _.pluck(vm.$$moodCounts, 'label'),
				datasets: [
					{
						label          : "Moods",
						fillColor      : "rgba(220, 220, 220 , .5 )",
						strokeColor    : "rgba(220, 220, 220 , .8 )",
						highlightFill  : "rgba(220, 220, 220 , .75)",
						highlightStroke: "rgba(220, 220, 220 ,1   )",
						data           : _.pluck(vm.$$moodCounts, 'count')
					}
				]
			};

			var options = configChart.bar;

			new Chart(ctx).Bar(data, options);
		}
	}

})();
