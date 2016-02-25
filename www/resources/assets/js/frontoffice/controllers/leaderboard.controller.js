/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('LeaderboardCtrl', LeaderboardCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	LeaderboardCtrl.$inject = [
		'$scope'
	];

	function LeaderboardCtrl($scope) {

		$scope.leaderboard = [
			{
				position: 1,
				score: 910,
				user: {
					firstName: "Jane"
				},
				company: {
					name: "Arteveldehogeschool"
				}
			},{
				position: 2,
				score: 44,
				user: {
					firstName: "Olivier"
				},
				company: {
					name: "Superstar-up"
				}
			},{
				position: 3,
				score: 30,
				user: {
					firstName: "Christel"
				},
				company: {
					name: "Arteveldehogeschool"
				}
			}
		];

	}

})();
