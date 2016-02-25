/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('CategoryModelFactory', CategoryModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	CategoryModelFactory.$inject = [
		'GoalModelFactory'
	];

	function CategoryModelFactory(
		GoalModelFactory
	) {
		/**
		 * Category Model. Category for goals.
		 *
		 * @param data
		 * @constructor
		 */
		function Category(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// Properties
			this.description = data.description || null;
			this.name        = data.name || null;
			this.goals       = this.$$addGoals(data.goals);
			this.order       = this.$$setOrder(data.order);
		}

		// Methods
		// =======

		Category.prototype.$$addGoals = function (goals) {
			if (angular.isDefined(goals) && angular.isArray(goals)) {
				return goals.map(function (element) {
					return new GoalModelFactory(element);
				})
			} else {
				return [];
			}
		};

		Category.prototype.$$setOrder = function (order) {
			return angular.isNumber(order) ? order : null;
		};

		return Category;
	}

})();
