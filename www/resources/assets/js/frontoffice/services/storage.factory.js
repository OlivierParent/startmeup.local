/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuServices')
		.factory('StorageFactory', StorageFactory);

	// Inject dependencies into constructor (needed when JS minification is applied).
	StorageFactory.$inject = [
		// Angular
		'$log',
		'$window',
		// Custom
		'CategoryModelFactory',
		'UserModelFactory'
	];

	function StorageFactory(
		// Angular
		$log,
		$window,
		// Custom
		CategoryModelFactory,
		UserModelFactory
	) {
		function get(key) {
			var value = $window.localStorage.getItem(key);
			//$log.info('get `' + key + '`: ', value);
			return value;
		}

		function getCategoryModel(key) {
			var object = getObject(key);
			if (angular.isArray(object)) {
				return object.map(function (value) {
					return new CategoryModelFactory(value);
				})
			} else {
				return new CategoryModelFactory(object);
			}
		}

		function getObject(key) {
			var objectJson = get(key);

			return angular.fromJson(objectJson);
		}

		function getUserModel(key) {
			var object = getObject(key);

			return new UserModelFactory(object);
		}

		function has(key) {
			return $window.localStorage.hasOwnProperty(key);
		}

		function remove(key) {
			$window.localStorage.removeItem(key);
		}

		function set(key, value) {
			//$log.info('set `' + key + '`: ', value);
			$window.localStorage.setItem(key, value);
		}

		function setObject(key, object) {
			var objectJson = angular.toJson(object);
			this.set(key, objectJson);
		}

		return {
			Local: {
				get             : get,
				getCategoryModel: getCategoryModel,
				getObject       : getObject,
				getUserModel    : getUserModel,
				has             : has,
				remove          : remove,
				set             : set,
				setObject       : setObject
			}
		};
	}

})();
