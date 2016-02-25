/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
;(function () { 'use strict';

	angular.module('smuApplication')
		.constant('INCREMENT_TYPES', {
			a_QuarterHour: {
				value: 'QUARTER_HOUR',
				label: 'Quarter hour',
				minutes: 15
			},
			b_Hour: {
				value: 'HOUR',
				label: 'Hour',
				minutes: 60
			},
			c_Day: {
				value: 'DAY',
				label: 'Day',
				minutes: 480
			}
		})

		.constant('MOOD_TYPES', {
			a_FeelingEnergized: {
				value: 'ENERGIZED',
				label: 'Energized'
			},
			b_FeelingGood: {
				value: 'GOOD',
				label: 'Good'
			},
			c_FeelingOk: {
				value: 'OK',
				label: 'Ok'
			},
			d_FeelingTired: {
				value: 'TIRED',
				label: 'Tired'
			},
			e_FeelingExhausted: {
				value: 'EXHAUSTED',
				label: 'Exhausted'
			}
		})

		.constant('PRIORITY_TYPES', {
			a_Highest: {
				value: 'HIGHEST',
				label: 'Highest priority'
			},
			b_High: {
				value: 'HIGH',
				label: 'High priority'
			},
			c_Normal: {
				value: 'NORMAL',
				label: 'Normal priority'
			},
			d_Low: {
				value: 'LOW',
				label: 'Low priority'
			},
			e_Lowest: {
				value: 'LOWEST',
				lable: 'Lowest priority'
			}
		})

		.constant('REPEAT_TYPES', {
			a_Daily: {
				value: 'DAILY',
				label: 'Every day'
			},
			b_Weekly: {
				value: 'WEEKLY',
				label: 'Every week'
			},
			c_Fortnightly: {
				value: 'FORTNIGHTLY',
				label: 'Every 2 weeks'
			},
			d_Monthly: {
				value: 'MONTHLY',
				label: 'Every month'
			}
		})

		.constant('TARGET_TYPES', {
			a_Checkbox: {
				value: 'TargetCheckbox',
				label: 'Checkbox'
			},
			b_RecurringCheckbox: {
				value: 'TargetRecurringCheckbox',
				label: 'Recurring Checkbox'
			},
			c_Duration: {
				value: 'TargetDuration',
				label: 'Duration'
			}
		})

		.constant('configApi', {
			protocol: null,
			host    : null,
			path    : '/api/v1/'
		})

		.constant('configChart', {
			bar: {
				//Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
				scaleBeginAtZero : true,

				//Boolean - Whether grid lines are shown across the chart
				scaleShowGridLines : true,

				//String - Colour of the grid lines
				scaleGridLineColor : "rgba(0,0,0,.05)",

				//Number - Width of the grid lines
				scaleGridLineWidth : 1,

				//Boolean - Whether to show horizontal lines (except X axis)
				scaleShowHorizontalLines: true,

				//Boolean - Whether to show vertical lines (except Y axis)
				scaleShowVerticalLines: true,

				//Boolean - If there is a stroke on each bar
				barShowStroke : true,

				//Number - Pixel width of the bar stroke
				barStrokeWidth : 2,

				//Number - Spacing between each of the X value sets
				barValueSpacing : 5,

				//Number - Spacing between data sets within X values
				barDatasetSpacing : 1,

				//String - A legend template
				legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
			},
			line: {

				//Boolean - Whether grid lines are shown across the chart
				scaleShowGridLines : true,

				//String - Colour of the grid lines
				scaleGridLineColor : "rgba(0,0,0,.05)",

				//Number - Width of the grid lines
				scaleGridLineWidth : 1,

				//Boolean - Whether to show horizontal lines (except X axis)
				scaleShowHorizontalLines: true,

				//Boolean - Whether to show vertical lines (except Y axis)
				scaleShowVerticalLines: true,

				//Boolean - Whether the line is curved between points
				bezierCurve : true,

				//Number - Tension of the bezier curve between points
				bezierCurveTension : 0.4,

				//Boolean - Whether to show a dot for each point
				pointDot : true,

				//Number - Radius of each point dot in pixels
				pointDotRadius : 4,

				//Number - Pixel width of point dot stroke
				pointDotStrokeWidth : 1,

				//Number - amount extra to add to the radius to cater for hit detection outside the drawn point
				pointHitDetectionRadius : 20,

				//Boolean - Whether to show a stroke for datasets
				datasetStroke : true,

				//Number - Pixel width of dataset stroke
				datasetStrokeWidth : 2,

				//Boolean - Whether to fill the dataset with a colour
				datasetFill : true,

				//String - A legend template
				legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
			}
		})

		.constant('configMap', {
			tile: {
				urlTemplate: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
				options: {
					attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
				}
			},
			icon: {
				company: {
					iconUrl     : '/images/nearby/icon.svg',
					iconSize    : [50,  50], // size of the icon
					iconAnchor  : [50,  50], // point of the icon which will correspond to marker's location
					popupAnchor : [ 0, -25], // point from which the popup should open relative to the iconAnchor
					shadowUrl   : '/images/nearby/icon-shadow.svg',
					shadowSize  : [50, 50], // size of the shadow
					shadowAnchor: [52, 50]  // the same for the shadow
				},
				user: {
					iconUrl    : '/images/nearby/icon-user.svg',
					iconSize   : [50,  50], // size of the icon
					iconAnchor : [25,  48], // point of the icon which will correspond to marker's location
					popupAnchor: [ 0, -48]  // point from which the popup should open relative to the iconAnchor
				}
			}
		});

})();
