/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('MoodModelFactory', MoodModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	MoodModelFactory.$inject = [
		// Angular
		'$log',
		// Constants
		'MOOD_TYPES'
	];

	function MoodModelFactory(
		// Angular
		$log,
		// Constants
		MOOD_TYPES
	) {
		// Note: Angular hides properties prefixed with `$$` when converting to JSON
		/**
		 * Mood Model. A user has moods.
		 *
		 * @param data
		 * @constructor
		 */
		function Mood(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// FK
			this.user_id = data.user_id || null;

			// Properties
			this.feeling = data.feeling || null;
		}

		// Methods
		// =======
		Mood.prototype.$$hasFeeling = function (feeling) {
			return this.feeling === feeling;
		};

		Mood.prototype.$$setFeeling = function (feeling) {
			switch (feeling) {
				case MOOD_TYPES.a_FeelingEnergized.value:
				case MOOD_TYPES.b_FeelingGood.value:
				case MOOD_TYPES.c_FeelingOk.value:
				case MOOD_TYPES.d_FeelingTired.value:
				case MOOD_TYPES.e_FeelingExhausted.value:
					this.feeling = feeling;
					break;
				default:
					this.feeling = null;
					break;
			}
		};

		return Mood;
	}

})();
