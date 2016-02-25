@extends('layouts.frontoffice')

@section('head-styles')
	@parent
	{!! Html::style('styles/css/styleguide.css') !!}
@stop

@section('head-scripts')
	@parent
	{!! Html::script('scripts/js/styleguide.js') !!}
@stop

@section('content')
<body ng-controller="StyleGuideCtrl as vm" id="style-guide">
	<h1 class="style-guide">StartMeUp Style Guide</h1>
	<p class="style-guide">This is the style guide for the <a href="http://www.startmeupbuddy.io">StartMeUp</a> web app developed at <a href="http://arteveldehogeschool.be/en">Artevelde University College Ghent</a>.</p>

	<md-divider class="style-guide"></md-divider>

	<section>
		<h2 class="style-guide">Headings</h2>
		<div class="style-guide">
			<h1>Heading Level 1</h1>
			<h2>Heading Level 2</h2>
			<h3>Heading Level 3</h3>
			<h4>Heading Level 4</h4>
			<h5>Heading Level 5</h5>
			<h6>Heading Level 6</h6>
		</div>
	</section>

	<md-divider class="style-guide"></md-divider>

	<section>
		<h2 class="style-guide">Paragraphs</h2>
		<div class="style-guide">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae consequatur distinctio ea expedita fugiat libero obcaecati reiciendis reprehenderit? Accusantium consectetur delectus deleniti doloribus eius excepturi magni neque sint sit sunt!</p>
			<p>Adipisci dolorum error officia sint! Nulla, odit, sequi. At autem blanditiis consectetur distinctio, dolorem earum error eveniet facilis fuga illum modi molestias, neque perspiciatis qui quod ratione saepe tenetur ullam?</p>
			<p>Ad aspernatur atque delectus deleniti doloremque earum eligendi fugit impedit ipsa iste molestiae mollitia nemo, nihil non obcaecati officiis omnis optio pariatur perferendis placeat possimus quidem sapiente similique velit voluptatum?</p>
			<p>Lorem ipsum <a href="">dolor sit amet</a>, consectetur adipisicing elit. Ad blanditiis delectus dolores, eligendi excepturi fugiat incidunt ipsum, iure iusto maiores nobis placeat porro quia quod repudiandae similique tempore, tenetur voluptatem!</p>
		</div>
	</section>

	<md-divider class="style-guide"></md-divider>

	<section>
		<h2 class="style-guide">Forms</h2>

		<h3 class="style-guide">Checkboxes</h3>
		<div class="style-guide">
			<form action="" name="styleGuideForm">
				<md-checkbox ng-model="vm.checkboxes.cb0" aria-label="Checkbox">
					Value: @{{ vm.checkboxes.cb0 }}
				</md-checkbox>

				<md-checkbox ng-model="vm.checkboxes.cb1" ng-true-value="'yes'" ng-false-value="'no'" aria-label="Checkbox with custom values">
					Value: @{{ vm.checkboxes.cb1 }}
				</md-checkbox>

				<md-checkbox ng-model="vm.checkboxes.cb2" ng-disabled="true" aria-label="Disabled checkbox">
					Checkbox (Disabled)
				</md-checkbox>

				<md-checkbox ng-model="vm.checkboxes.cb3" ng-init="checkboxes.cb3=true" ng-disabled="true" aria-label="Disabled checked checkbox" >
					Checkbox (Disabled, Checked)
				</md-checkbox>

				<md-checkbox ng-model="vm.checkboxes.cb4" md-no-ink aria-label="Checkbox No Ink">
					Checkbox (No Ink)
				</md-checkbox>
			</form>
		</div>

		<h3 class="style-guide">Radiobuttons</h3>
		<div class="style-guide">
			<form action="" name="styleGuideForm">
				<md-radio-group ng-model="vm.user.gender" layout layout-sm="column">
					<md-radio-button flex value="f" aria-label="female">female</md-radio-button>
					<md-radio-button flex value="m" aria-label="male">male</md-radio-button>
					<md-radio-button flex value="o" aria-label="other">other</md-radio-button>
				</md-radio-group>

				<p>I&rsquo;m a:</p>
				<md-radio-group ng-model="vm.user.role">
					<md-radio-button value="prestarter" aria-label="prestarter">prestarter</md-radio-button>
					<md-radio-button value="starter" aria-label="starter">starter</md-radio-button>
					<md-radio-button value="serial" aria-label="serial entrepreneur" lang="en">serial entrepreneur</md-radio-button>
				</md-radio-group>
			</form>
		</div>

		<h3 class="style-guide">Switches</h3>
		<div class="style-guide">
			<form action="" name="styleGuideForm">
				<div layout layout-sm="column">
					<md-switch flex  ng-model="vm.switches.sw0" ng-true-value="'Yes I do want to collaborate with others'" ng-false-value="'No I don&rsquo;t want to collaborate with others'" aria-label="Switch 1">
						@{{ vm.switches.sw0 }}
					</md-switch>
				</div>
			</form>
		</div>

		<h3 class="style-guide">Selects</h3>
		<div class="style-guide">
			<form action="" name="styleGuideForm">
				<md-select ng-model="vm.goals" placeholder="Categories">
					<md-optgroup label="Category A">
						<md-option ng-value="vm.goal.name" ng-repeat="goal in goals | filter: {category: 'Category A' }">@{{ goal.name }}</md-option>
					</md-optgroup>
					<md-optgroup label="Category B">
						<md-option ng-value="vm.goal.name" ng-repeat="goal in goals | filter: {category: 'Category B' }">@{{ goal.name }}</md-option>
					</md-optgroup>
				</md-select>
			</form>
		</div>

		<h3 class="style-guide">Inputs</h3>
		<div class="style-guide">
			<form action="" name="styleGuideForm">
				<div layout layout-sm="column">
					<md-input-container flex>
						<label>First name</label>
						<input ng-model="vm.user.firstName" name="firstName" required>
						<div ng-messages="styleGuideForm.firstName.$error">
							<div ng-message="required">This field is required.</div>
						</div>
					</md-input-container>
					<md-input-container flex>
						<label>Last name</label>
						<input ng-model="vm.user.lastName" name="lastName" required>
						<div ng-messages="styleGuideForm.lastName.$error">
							<div ng-message="required">Dit veld is verplicht.</div>
						</div>
					</md-input-container>
				</div>

				<md-input-container>
					<label>Birthday</label>
					<input type="date" ng-model="vm.user.birthday">
				</md-input-container>

				<div layout layout-sm="column">
					<md-input-container flex>
						<label>Mobile phone</label>
						<input ng-model="vm.user.mobilePhone">
					</md-input-container>
					<md-switch flex ng-model="vm.switches.sw1" ng-true-value="'public'" ng-false-value="'private'"  aria-label="Switch 1">
						@{{ vm.switches.sw1 }}
					</md-switch>
				</div>

				<div layout layout-sm="column">
					<md-input-container flex>
						<label>Email</label>
						<input ng-model="vm.user.email" type="email">
					</md-input-container>
					<md-switch flex ng-model="vm.switches.sw2" ng-true-value="'public'" ng-false-value="'private'"  aria-label="Switch 1">
						@{{ vm.switches.sw2 }}
					</md-switch>
				</div>

				<!-- http://microformats.org/wiki/h-adr -->

				<div layout layout-sm="column">
					<md-input-container flex>
						<label>Street</label>
						<input ng-model="vm.company.address.street" name="street" required>
					</md-input-container>
				</div>

				<div layout layout-sm="column">
					<md-input-container flex>
						<label>Postal code</label>
						<input ng-model="vm.company.address.postalCode" name="postalCode" required>
					</md-input-container>
					<md-input-container flex>
						<label>Locality</label>
						<input ng-model="vm.company.address.city" name="locality" required>
					</md-input-container>
				</div>

			</form>
		</div>
	</section>

	<md-divider class="style-guide"></md-divider>

	<section>
		<h2 class="style-guide">Progress Bars</h2>
		<div class="style-guide">
			<md-progress-linear md-mode="determinate" value="33"></md-progress-linear>
			<br>
			<md-progress-linear md-mode="determinate" value="66"></md-progress-linear>
			<br>
			<md-progress-linear md-mode="determinate" value="100"></md-progress-linear>
			<br>

			<br>
			<md-progress-linear md-mode="determinate" value="25"></md-progress-linear>
			<br>
			<md-progress-linear md-mode="determinate" value="50"></md-progress-linear>
			<br>
			<md-progress-linear md-mode="determinate" value="75"></md-progress-linear>
			<br>
			<md-progress-linear md-mode="determinate" value="100"></md-progress-linear>
			<br>
		</div>
	</section>

	<md-divider class="style-guide"></md-divider>

	<section>
		<h2 class="style-guide">Charts</h2>
		<div class="style-guide">
			<canvas id="style-guide-chart-0" width="400" height="400"></canvas>
			<canvas id="style-guide-chart-1" width="400" height="400"></canvas>
		</div>
	</section>

	<md-divider class="style-guide"></md-divider>

	<section>
		<h2 class="style-guide">Map</h2>
		<div class="style-guide">
			<div id="style-guide-map-0" class="style-guide-map"></div>
		</div>
	</section>

</body>
@stop

