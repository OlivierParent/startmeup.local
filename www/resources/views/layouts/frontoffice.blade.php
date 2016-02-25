<!DOCTYPE html>
<html lang="en" ng-app="smuApplication">
<head>
	<meta charset="UTF-8">
	<title>StartMeUp</title>
	<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="apple-touch-icon" href="{{ URL::asset('images/touch-icon-iphone.png') }}" sizes="57x57">
	<link rel="apple-touch-icon" href="{{ URL::asset('images/touch-icon-ipad.png') }}" sizes="72x72">
	<link rel="apple-touch-icon" href="{{ URL::asset('images/touch-icon-iphone-retina.png') }}" sizes="114x114">
	<link rel="apple-touch-icon" href="{{ URL::asset('images/touch-icon-ipad-retina.png') }}" sizes="144x144">
@section('head-styles')
	{!! Html::style('//fonts.googleapis.com/css?family=Quicksand:300,400,700') !!}
	{!! Html::style('styles/css/angular.css') !!}
	{!! Html::style('styles/css/leaflet.css') !!}
	{!! Html::style('styles/css/frontoffice.css') !!}
@show
@section('head-scripts')
	{!! Html::script('scripts/js/angular.js') !!}
	{!! Html::script('scripts/js/chart.js') !!}
	{!! Html::script('scripts/js/leaflet.js') !!}
	{!! Html::script('scripts/js/lodash.js') !!}
	{!! Html::script('scripts/js/moment.js') !!}
	{!! Html::script('scripts/js/frontoffice.js') !!}
@show
</head>
@yield('content')
</html>
