/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('RegistrationFormStateFactory', RegistrationFormStateFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	RegistrationFormStateFactory.$inject = [
		// Custom
		'AddressModelFactory',
		'CompanyModelFactory',
		'CountryModelFactory',
		'LocalityModelFactory',
		'RegionModelFactory',
		'SettingsModelFactory',
		'UserModelFactory'
	];

	function RegistrationFormStateFactory(
		// Custom
		AddressModelFactory,
		CompanyModelFactory,
		CountryModelFactory,
		LocalityModelFactory,
		RegionModelFactory,
		SettingsModelFactory,
		UserModelFactory
	) {
		return {
			address : new AddressModelFactory(),
			country : new CountryModelFactory(),
			company : new CompanyModelFactory(),
			locality: new LocalityModelFactory(),
			region  : new RegionModelFactory(),
			settings: new SettingsModelFactory(),
			user    : new UserModelFactory()
		};
	}

})();
