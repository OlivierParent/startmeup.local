/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UserModelFactory', UserModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UserModelFactory.$inject = [
		// Angular
		'$log',
		// Custom
		'InterestModelFactory'
	];

	function UserModelFactory(
		// Angular
		$log,
		// Custom
		InterestModelFactory
	) {
		/**
		 * User Model.
		 *
		 * @param data
		 * @constructor
		 */
		function User(data) {
			data = data || {};

			moment.locale('en');

			// PK
			this.id = data.id || null;

			// Properties
			this.name      = data.name || null;
			this.password  = data.password || null;
			this.birthday  = data.birthday || null;
			this.interests = data.interests || [];

			// Properties omitted from JSON by Angular due to `$$` prefix.
			this.$$birthday           = this.$$toDate(this.birthday);
			this.$$interests          = []; // All possible interests should be pushed to this array.
			this.$$interestSearchText = '';
			this.$$interestSelected   = null;
		}

		// Methods
		// =======
		User.prototype.$$addInterest = function (chip) {
			var interest;

			if (angular.isObject(chip)) {
				interest = chip;
			} else {
				var data = { name: chip };
				interest = new InterestModelFactory(data);

				// Add to complete list of interests (`md-no-cache` required on `md-autocomplete`)
				this.$$interests.push(interest);
			}

			return interest;
		};

		User.prototype.$$getSetBirthday = function (newValue) {
			if (arguments.length) {
				this.birthday = moment(newValue).format('YYYY-MM-DD');
				return this.$$birthday = newValue;
			} else {
				return this.$$birthday;
			}
		};

		User.prototype.$$interestFilter = function (interestSearchText) {
			var searchText = angular.uppercase(interestSearchText);

			return function(interest) {
				return (interest.$$name.indexOf(searchText) === 0);
			};
		};

		User.prototype.$$interestSearchTextChanged = function () {};

		User.prototype.$$interestSelectedItemChange = function () {};

		User.prototype.$$searchInterest = function () {
			return this.$$interests.filter(this.$$interestFilter(this.$$interestSearchText));
		};

		User.prototype.$$toDate = function (dateString) {
			return angular.isString(dateString) ? moment(dateString).toDate() : null;
		};

		return User;
	}

})();
