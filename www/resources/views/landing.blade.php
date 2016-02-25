@extends('layouts.frontoffice')

@section('content')
<body>
	<md-content class="md-padding" layout="column" layout-align="center center">
		<style>
			section {
				max-width: 60em;
				padding: 1em;
				width: 100%;
			}
			section > h1,
			section > p {
				margin: auto;
				max-width: 30em;
				padding-bottom: 1em;
			}
			section > h1 {
				max-width: 15em;
				width: 100%;
			}
			footer > p {
				text-align: center;
			}
			footer > p > a > img {
				max-width: 15em;
			}
			.md-button + .md-button {
				margin-left: 1em;
			}
		</style>
		<section class="md-whiteframe-z1">

			<h1><a href="{{ URL::route('frontoffice.home') }}"><img src="images/logo_app.svg" alt="startmeupbuddy.io"></a></h1>

			<p>You are a <strong>born entrepreneur</strong>, but sometimes you feel like you are alone in your world? You are looking for <strong>peers</strong>? You are looking for support? You are looking for that extra trigger that keeps it exciting. <strong>Celebrations</strong> to your efforts and <strong>achievements</strong>?</p>

			<p>StartMeUp.io, a <strong>mobile buddy</strong> app will give you these little moments of support and celebration. A personal coach in your venture, it is always there and it gives you support.</p>

			<p>Based on the data you put in, you will receive <strong>feedback loops</strong>. The more you use the app, the better it will get to know you, the better it will support you.</p>

			<h2 class="centered">Co-creation – open source</h2>
			<p>The open source app is in <strong>co-creation</strong> with students, pre- and early stage starters. Once we have a solid prototype we can open it up to the community for further improvements and subject for debate.</p>

			<h2 class="centered">Aim of project</h2>
			<p>The aim of this research project is to test it out among <strong>startup communities</strong> in different regions. The data can be used in research to map entrepreneurial behaviour.</p>

			<p>In addition we see it as tool that can be embedded in the curriculum of students to test their entrepreneurial skills.</p>

			<footer>
				<p><a href="http://www.arteveldehogeschool.be/en"><img src="images/logo_arteveldehogeschool.svg" alt="Artevelde University College Ghent"></a></p>
				<p>©2014-{{ Carbon\Carbon::now()->year }} Christel De Maeyer, Karijn Bonne &amp; Olivier Parent</p>
				<p><img src="images/email_christel.svg" alt="Contact Christel De Maeyer"></p>
			</footer>
		</section>

		<section layout="row" layout-sm="column" layout-align="center center">
			{!! Html::linkRoute('frontoffice.home', 'Web App'    , [], ['class' => 'md-button md-raised md-accent md-default-theme']) !!}
			{!! Html::linkRoute('backoffice.home' , 'Admin'      , [], ['class' => 'md-button md-raised md-default-theme']) !!}
			{!! Html::linkRoute('styleguide.home' , 'Style Guide', [], ['class' => 'md-button md-raised md-default-theme']) !!}
		</section>

	</md-content>
</body>
@stop
