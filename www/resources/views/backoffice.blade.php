@extends('layouts.backoffice')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					<p>You are logged in at {!! Carbon\Carbon::now()->formatLocalized('%H:%M:%S <abbr title="Coordinated Universal Time">UTC</abbr> on %A %d %B %Y') !!}!</p>
					<p style="text-align: center"><img src="{!! asset('images/logo.svg') !!}" width="200"></p>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
