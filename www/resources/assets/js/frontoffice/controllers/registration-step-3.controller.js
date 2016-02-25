/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('RegistrationStep3Ctrl', RegistrationStep3Ctrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	RegistrationStep3Ctrl.$inject = [
		// Angular
		'$log',
		'$scope',
		'$window',
		// Custom
		'AddressResourceFactory',
		'CompanyResourceFactory',
		'CountryResourceFactory',
		'CountryUiModelFactory',
		'DialogFactory',
		'LocalityResourceFactory',
		'LocalityUiModelFactory',
		'RegionResourceFactory',
		'RegionUiModelFactory',
		'RegistrationFormStateFactory',
		'ToastFactory',
		'UserResourceFactory',
		'UserSettingsResourceFactory'
	];

	function RegistrationStep3Ctrl(
		// Angular
		$log,
		$scope,
		$window,
		// Custom
		AddressResourceFactory,
		CompanyResourceFactory,
		CountryResourceFactory,
		CountryUiModelFactory,
		DialogFactory,
		LocalityResourceFactory,
		LocalityUiModelFactory,
		RegionResourceFactory,
		RegionUiModelFactory,
		RegistrationFormStateFactory,
		ToastFactory,
		UserResourceFactory,
		UserSettingsResourceFactory
	) {
		$log.info('Registration: step 3');
		// ViewModel
		// =========
		var vm = this;

		// Get the form state.
		var formState = RegistrationFormStateFactory;
		vm.address  = formState.address;
		vm.country  = formState.country;
		vm.company  = formState.company;
		vm.locality = formState.locality;
		vm.region   = formState.region;
		vm.settings = formState.settings;
		vm.user     = formState.user;
		$log.log('vm:', vm);

		vm.$$country  = new CountryUiModelFactory();
		vm.$$region   = new RegionUiModelFactory();
		vm.$$locality = new LocalityUiModelFactory();

		vm.processFormStep = processFormStep;

		// Watchers
		// --------
		// UI Watchers
		$scope.$watch('vm.$$country.$$selected' , watchCountryUiHandler);
		$scope.$watch('vm.$$locality.$$selected', watchLocalityUiHandler);
		$scope.$watch('vm.$$region.$$selected'  , watchRegionUiHandler);

		// Normal Watchers
		$scope.$watch('vm.locality.name', watchLocalityHandler);
		$scope.$watch('vm.region.name'  , watchRegionHandler);

		// Functions
		// =========
		function gotoNextStep() {
			$window.location.href = '#/registration/step/4/of/4';
		}

		function processFormStep(event) {
			event.preventDefault();
			$log.info('vm:', vm);
			if ($scope.registration_form.$valid) {
				if (angular.isNumber(vm.user.id)) {
					process1Country();
				} else {
					ToastFactory.show('Please complete the previous steps first');
				}
			} else {
				ToastFactory.show('Please fill in the required fields to continue!');
			}
			$log.info('vm:', vm);
		}

		function process1Country() {
			$log.info('process1Country:', vm.country);
			// Set the form state.
			formState.country = vm.country;
			if (angular.isNumber(vm.country.id)) {
				$log.log('Using country:', vm.country.id);
				process2Region();
			} else {
				formState.country.name = vm.$$country.$$searchTextName;
				saveCountry();
			}
		}

		function process2Region() {
			$log.info('process2Region:', vm.region);
			// Set the form state.
			formState.region = vm.region;
			if (angular.isNumber(vm.region.id)) {
				$log.log('Using region:', vm.region.id);
				process3Locality();
			} else {
				formState.region.name       = vm.$$region.$$searchTextName;
				formState.region.country_id = vm.country.id;
				saveRegion();
			}
		}

		function process3Locality() {
			$log.info('process3Locality');
			// Set the form state.
			formState.locality = vm.locality;
			if (angular.isNumber(vm.locality.id)) {
				$log.log('Using locality: ', vm.locality.id);
				process4Address();
				// @todo Update resource.
			} else {
				formState.locality.name        = vm.$$locality.$$searchTextName;
				formState.locality.postal_code = vm.$$locality.$$searchTextPostalCode;
				formState.locality.region_id   = vm.region.id;
				saveLocality();
			}
		}

		function process4Address() {
			$log.info('process4Address');
			// Set the form state.
			formState.address = vm.address;
			if (angular.isNumber(vm.address.id)) {
				$log.log('Using address: ', vm.address.id);
				process5Company();
				// @todo Update resource.
			} else {
				saveAddress();
			}
		}

		function process5Company() {
			$log.info('process5Company');
			// Set the form state.
			formState.company = vm.company;
			if (angular.isNumber(vm.company.id)) {
				$log.log('Using company: ', vm.company.id);
				process6User();
				// @todo Update resource.
			} else {
				saveCompany();
			}
		}

		function process6User() {
			$log.info('process6User');
			updateUser();
		}

		function process7Settings() {
			$log.info('process7Settings');
			updateUserSettings();
		}

		// Address
		// -------
		function saveAddress() {
			$log.info('saveAddress');
			var addressResource = new AddressResourceFactory;
			addressResource.address             = vm.address;
			addressResource.address.locality_id = vm.locality.id;
			addressResource.$save()
				.then(saveAddressResourceSuccess)
				.catch(saveAddressResourceError);
		}

		function saveAddressResourceError(reason) {
			$log.error('saveAddressResourceError:', reason);
			DialogFactory
				.showItems('The address could not be saved!', reason.errors);
		}

		function saveAddressResourceSuccess(response) {
			$log.log('saveAddressResourceSuccess:', response);
			vm.address.id = response.id;
			process5Company();
		}

		// Company
		// -------
		function saveCompany() {
			$log.info('saveCompany');
			var companyResource = new CompanyResourceFactory;
			companyResource.company            = vm.company;
			companyResource.company.address_id = vm.address.id;
			companyResource.$save()
				.then(saveCompanyResourceSuccess)
				.catch(saveCompanyResourceError);
		}

		function saveCompanyResourceError(reason) {
			$log.error('saveCompanyResourceError:', reason);
			DialogFactory
				.showItems('The company profile could not be saved!', reason.errors);
		}

		function saveCompanyResourceSuccess(response) {
			$log.log('saveCompanyResourceSuccess:', response);
			vm.company.id = response.id;
			process6User();
		}

		// Country
		// -------
		function saveCountry() {
			$log.info('saveCountry');
			var countryResource = new CountryResourceFactory();
			countryResource.country = formState.country;
			countryResource.$save()
				.then(saveCountryResourceSuccess)
				.catch(saveCountryResourceError);
		}

		function saveCountryResourceError(reason) {
			$log.error('saveCountryResourceError:', reason);
			DialogFactory
				.showItems('The country could not be saved!', reason.errors);
		}

		function saveCountryResourceSuccess(response) {
			$log.log('saveCountryResourceSuccess:', response);
			vm.country.id = response.id;
			process2Region();
		}

		// Locality
		// --------
		function saveLocality() {
			$log.info('saveLocality');
			var localityResource = new LocalityResourceFactory();
			localityResource.locality = formState.locality;
			localityResource.$save()
				.then(saveLocalityResourceSuccess)
				.catch(saveLocalityResourceError);
		}

		function saveLocalityResourceError(reason) {
			$log.error('saveLocalityResourceError:', reason);
			DialogFactory
				.showItems('The postal code and locality could not be saved!', reason.errors);
		}

		function saveLocalityResourceSuccess(response) {
			$log.log('saveLocalityResourceSuccess:', response);
			vm.locality.id = response.id;
			process4Address();
		}

		// Region
		// ------
		function saveRegion() {
			$log.info('saveRegion');
			var regionResource = new RegionResourceFactory();
			regionResource.region = formState.region;
			regionResource.$save()
				.then(saveRegionResourceSuccess)
				.catch(saveRegionResourceError);
		}

		function saveRegionResourceError(reason) {
			$log.error('saveRegionResourceError:', reason);
			DialogFactory
				.showItems('The region could not be saved!', reason.errors);
		}

		function saveRegionResourceSuccess(response) {
			$log.log('saveRegionResourceSuccess:', response);
			vm.region.id = response.id;
			process3Locality();
		}

		// User
		// ----
		function updateUser() {
			var userResource = new UserResourceFactory;
			var params = {
				userId: vm.user.id
			};
			userResource.$get(params)
				.then(function () {
					userResource.company_id = vm.company.id;
					userResource.$update()
						.then(updateUserResourceSuccess)
						.catch(updateUserResourceError);
				});
		}

		function updateUserResourceError(reason) {
			$log.error('updateUserResourceError:', reason);
			DialogFactory
				.showItems('The user profile could not be updated!', reason.errors);
		}

		function updateUserResourceSuccess(response) {
			$log.log('updateUserResourceSuccess:', response);
			process7Settings();
		}

		// UserSettings
		// ------------
		function updateUserSettings() {
			$log.info('updateUserSettings');
			var userSettingsResource = new UserSettingsResourceFactory;
			var params = {
				userId    : formState.user.id,
				settingsId: formState.settings.id
			};
			userSettingsResource.$get(params)
				.then(function () {
					angular.merge(userSettingsResource, formState.settings);
					userSettingsResource.$update(params)
						.then(updateUserSettingsResourceSuccess)
						.catch(updateUserSettingsResourceError);
				});
		}

		function updateUserSettingsResourceError(reason) {
			$log.error('saveUserSettingsResourceError:', reason);
			DialogFactory
				.showItems('The user settings could not be updated!', reason.errors);
		}

		function updateUserSettingsResourceSuccess(response) {
			$log.log('saveUserSettingsResourceSuccess:', response);
			ToastFactory
				.show('User settings updated!')
				.finally(gotoNextStep);
		}

		// Watch Handlers
		// --------------
		/**
		 * Change region if a known locality is selected
		 */
		function watchLocalityHandler() {
			$log.info('locality changed:', vm.locality, vm.$$locality);
			if (angular.isObject(vm.$$locality.$$selected) && angular.isObject(vm.$$locality.$$selected.region)) {
				$log.log('change');
				vm.$$region.$$selected   = vm.$$locality.$$selected.region;
				vm.$$region.$$searchText = vm.$$locality.$$selected.region.name;
			}
		}

		/**
		 * Change country if a known region is selected
		 */
		function watchRegionHandler() {
			$log.info('region changed:', vm.region, vm.$$region);
			if (angular.isObject(vm.$$region.$$selected) && angular.isObject(vm.$$region.$$selected.country)) {
				$log.log('change');
				vm.$$country.$$selected       = vm.$$region.$$selected.country;
				vm.$$country.$$searchTextName = vm.$$region.$$selected.country.name;
			}
		}

		// UI Watch handlers
		// -----------------
		/**
		 * Set country to selected country object, or create a new country object.
		 */
		function watchCountryUiHandler() {
			$log.info('ui country changed:', vm.$$country, vm.country);
			vm.country = angular.isObject(vm.$$country.$$selected) ? vm.$$country.$$selected : vm.$$country.$$createModel();
			$log.log('country:', vm.country);
		}

		/**
		 * Set locality to selected locality object, or create a new locality object.
		 */
		function watchLocalityUiHandler() {
			vm.locality = angular.isObject(vm.$$locality.$$selected) ? vm.$$locality.$$selected : vm.$$locality.$$createModel();
			$log.log('locality:', vm.locality);
		}

		/**
		 * Set region to selected region object, or create a new region object.
		 */
		function watchRegionUiHandler() {
			$log.info('ui region changed:', vm.$$region, vm.region);
			vm.region = angular.isObject(vm.$$region.$$selected) ? vm.$$region.$$selected : vm.$$region.$$createModel();
			$log.log('region:', vm.region);
		}

	}

})();
