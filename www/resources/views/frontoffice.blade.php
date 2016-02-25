@extends('layouts.frontoffice')

@section('content')
<body ng-controller="AppCtrl as app">
	<section layout="row" flex>
		<ng-include src="'templates/sidenav-left.partial.html'"></ng-include>
		<div class="view view-animate-container">
			<ng-view class="view view-animate" autoscroll="true"></ng-view>
		</div>
	</section>
</body>
@stop
