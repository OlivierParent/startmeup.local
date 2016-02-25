/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('GoalProgressCtrl', GoalProgressCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	GoalProgressCtrl.$inject = [
		// Angular
		'$log',
		'$routeParams',
		'$scope',
		// Constants
		'configChart'
	];

	function GoalProgressCtrl(
		// Angular
		$log,
		$routeParams,
		$scope,
		// Constants
		configChart
	) {
		$log.info('GoalProgressCtrl');

		$scope.categoryId = $routeParams.categoryId;
		$scope.goalId     = $routeParams.goalId;

		var ctx = document.getElementById("smu-chart-0").getContext("2d");

		var data = {
			labels: ["January", "February", "March", "April", "May", "June", "July"],
			datasets: [
				{
					label: "My First dataset",
					fillColor: "rgba(220,220,220,0.5)",
					strokeColor: "rgba(220,220,220,0.8)",
					highlightFill: "rgba(220,220,220,0.75)",
					highlightStroke: "rgba(220,220,220,1)",
					data: [12, 10, 11, 9, 5, 3, 2]
				}
			]
		};

		var smuChart0 = new Chart(ctx).Bar(data, configChart.bar);
	}

})();
