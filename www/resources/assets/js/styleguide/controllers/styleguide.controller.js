;(function () { 'use strict';

	angular.module('smuControllers')
		.controller('StyleGuideCtrl', StyleGuideCtrl);

	// Inject dependencies into constructor (needed when JS minification is applied).
	StyleGuideCtrl.$inject = [
		// Angular
		'$interpolate',
		// Config
		'configChart',
		'configMap'
	];

	function StyleGuideCtrl(
		// Angular
		$interpolate,
		// Config
		configChart,
		configMap
	) {
		// ViewModel
		var vm = this;

		vm.checkboxes = {
			cb0: true,
			cb1: 'yes',
			cb2: false,
			cb3: true,
			cb4: true
		};

		vm.switches = {
			sw0: 'Yes I do want to collaborate with others',
			sw1: 'public',
			sw2: 'public'
		};

		vm.user = {
			firstName: "Jane",
			lastName : "Doe"
		};

		vm.goals = [
			{ category: 'Category A', name: 'Goal 01' },
			{ category: 'Category A', name: 'Goal 02' },
			{ category: 'Category A', name: 'Goal 03' },
			{ category: 'Category A', name: 'Goal 04' },
			{ category: 'Category B', name: 'Goal 05' },
			{ category: 'Category B', name: 'Goal 06' },
			{ category: 'Category B', name: 'Goal 07' },
			{ category: 'Category B', name: 'Goal 08' }
		];

		/**
		 * Charts
		 */
		(function () {
			var ctx = document.getElementById("style-guide-chart-0").getContext("2d");

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

			var options = configChart.bar;

			new Chart(ctx).Bar(data, options);
		})();

		(function () {
			var ctx = document.getElementById("style-guide-chart-1").getContext("2d");

			var data = {
				labels: ["January", "February", "March", "April", "May", "June", "July"],
				datasets: [
					{
						label: "My First dataset",
						fillColor: "rgba(220,220,220,0.2)",
						strokeColor: "rgba(220,220,220,1)",
						pointColor: "rgba(220,220,220,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(220,220,220,1)",
						data: [65, 59, 80, 81, 56, 55, 40]
					},
					{
						label: "My Second dataset",
						fillColor: "rgba(151,187,205,0.2)",
						strokeColor: "rgba(151,187,205,1)",
						pointColor: "rgba(151,187,205,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(151,187,205,1)",
						data: [28, 48, 40, 19, 86, 27, 90]
					}
				]
			};

			var options = configChart.line;

			new Chart(ctx).Line(data, options);
		})();

		/**
		 * Map
		 */
		(function () {
			var templates = {
				company: '<b>{{ name }}</b><i><br>{{ strapline }}</i><br>{{ address.street }}<br>{{ address.locality }}',
				user: '<b>You</b><br>You are here!'
			};
			var compileTemplateCompany = $interpolate(templates.company);

			var locations = {
				companies: [{
					name: 'Arteveldehogeschool',
					strapline: 'Mediacampus Mariakerke',
					address: {
						street: 'Industrieweg 232',
						locality: '9030 Mariakerke'
					},
					point: [51.0950244, 3.6716606]
				},{
					name: 'Arteveldehogeschool',
					strapline: 'Campus Hoogpoort',
					address: {
						street: 'Hoogpoort 15',
						locality: '9000 Gent'
					},
					point: [51.0555987, 3.7229698]
				},{
					name: 'Arteveldehogeschool',
					strapline: 'Campus Kantienberg',
					address: {
						street: 'Voetweg 66',
						locality: '9000 Gent'
					},
					point: [51.0406693, 3.7271024]
				}]
			};

			var map = L.map('style-guide-map-0').setView(locations.companies[2].point, 12);
			L.tileLayer(configMap.tile.urlTemplate, configMap.tile.options).addTo(map);

			var iconCompany = L.icon(configMap.icon.company);

			// Draw company positions son map.
			locations.companies.forEach(geoDraw);

			// Current Position of User
			navigator.geolocation.getCurrentPosition(geoSuccess, geoError);

			function geoDraw(company) {
				var marker = L.marker(company.point, {icon: iconCompany}).addTo(map);

				marker.bindPopup(compileTemplateCompany(company)).openPopup();
			}

			function geoError() {
				$log.error('geolocation could not be determined');
			}

			function geoSuccess(position) {
				var point    = [position.coords.latitude, position.coords.longitude];
				var iconUser = L.icon(configMap.icon.user);
				var marker   = L.marker(point, {icon: iconUser}).addTo(map);

				marker.bindPopup(templates.user).openPopup();
			}

		})();

	}

})();
