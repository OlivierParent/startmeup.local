/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('SettingsModelFactory', SettingsModelFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	//SettingsModelFactory.$inject = [];

	function SettingsModelFactory() {
		/**
		 * Settings Model. Contains all user settings.
		 *
		 * @param data
		 * @constructor
		 */
		function Settings(data) {
			data = data || {};

			// PK
			this.id = data.id || null;

			// FK
			this.user_id = data.user_id || null;

			// Properties
			this.colour_palette      = data.colour_palette      || 'A';
			this.share_address       = data.share_address       || false;
			this.share_birthday      = data.share_birthday      || false;
			this.share_email         = data.share_email         || false;
			this.share_gender        = data.share_gender        || false;
			this.share_interests     = data.share_interests     || false;
			this.share_locality      = data.share_locality      || false;
			this.share_location      = data.share_location      || false;
			this.share_mobile        = data.share_mobile        || false;
			this.share_picture       = data.share_picture       || false;
			this.share_progress      = data.share_progress      || false;
			this.show_notifications  = data.show_notifications  || true;
			this.want_to_collaborate = data.want_to_collaborate || false;
		}

		// Methods
		// =======

		return Settings;
	}

})();
