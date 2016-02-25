/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('NearbyCtrl', NearbyCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	NearbyCtrl.$inject = [
		// Angular
		'$interpolate',
		'$log',
		// Constants
		'configMap',
		// Custom
		'LocationResourceFactory'
	];

	function NearbyCtrl(
		// Angular
		$interpolate,
		$log,
		// Constants
		configMap,
		// Custom
		LocationResourceFactory
	) {
		// ViewModel
		var vm = this;

		var templates = {
			location: '<b>{{ title }}</b><i><br>{{ subtitle }}</i><br>{{ address.street }} {{ address.street_number }}<br>{{ address.locality.postal_code }} {{ address.locality.name }}',
			user: '<b>You</b><br>You are here!'
		};

		var compileTemplateLocation = $interpolate(templates.location);

		var map = L.map('smu-map-0');
		L.tileLayer(configMap.tile.urlTemplate, configMap.tile.options).addTo(map);

		var iconCompany = L.icon(configMap.icon.company);

		LocationResourceFactory
			.queryWithAddress()
			.$promise
				.then(locationsSuccess)
				.catch(locationsError);

		navigator.geolocation.getCurrentPosition(geoSuccess, geoError);

		// Functions
		// ---------

		function geoDraw(company) {
			var point  = [company.latitude, company.longitude];
			var marker = L.marker(point, {icon: iconCompany}).addTo(map);

			marker.bindPopup(compileTemplateLocation(company)).openPopup();
		}

		function geoError() {
			$log.error('geolocation could not be determined');
		}

		// Current Position of User
		function geoSuccess(position) {
			var point    = [position.coords.latitude, position.coords.longitude];
			var iconUser = L.icon(configMap.icon.user);
			var marker   = L.marker(point, {icon: iconUser}).addTo(map);

			map.setView(point, 12);
			marker.bindPopup(templates.user).openPopup();
		}

		function locationsSuccess(response) {
			$log.log('locationsSuccess:', response);
			response.data.forEach(geoDraw);
		}

		function locationsError(reason) {
			$log.error('locationsError:', reason);
		}

	}

})();
