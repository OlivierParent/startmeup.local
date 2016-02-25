/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('UriFactory', UriFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	UriFactory.$inject = [
		// Angular
		'$location',
		// Custom
		'configApi'
	];

	function UriFactory(
		// Angular
		$location,
		// Custom
		configApi
	) {

		function getApi(path) {
			var protocol = configApi.protocol ? configApi.protocol : $location.protocol();
			var host     = configApi.host     ? configApi.host     : $location.host();
			var uri      = protocol + '://' + host + configApi.path + path;

			return uri;
		}

		function getDialog(uri) {
			return '/templates/' + uri + '.dialog.html';
		}

		function getPartialView(uri) {
			return '/templates/' + uri + '.partial.html';
		}

		function getToast(uri) {
			return '/templates/' + uri + '.toast.html';
		}

		function getView(uri) {
			return '/templates/' + uri + '.view.html';
		}

		return {
			getApi        : getApi,
			getDialog     : getDialog,
			getPartialView: getPartialView,
			getToast      : getToast,
			getView       : getView
		};

	}

})();
