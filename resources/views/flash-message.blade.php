@if ($message = Session::get('success'))
	<div class="uk-container uk-margin-top">
		<div class="uk-alert-success" uk-alert>
			<a class="uk-alert-close" uk-close></a>
			<p><strong>{{ $message }}</strong></p>
		</div>
	</div>
@endif

@if ($message = Session::get('info'))
	<div class="uk-container uk-margin-top">
		<div class="uk-alert-primary" uk-alert>
			<a class="uk-alert-close" uk-close></a>
			<p><strong>{{ $message }}</strong></p>
		</div>
	</div>
@endif

@if ($message = Session::get('warning'))
	<div class="uk-container uk-margin-top">
		<div class="uk-alert-warning" uk-alert>
			<a class="uk-alert-close" uk-close></a>
			<p><strong>{{ $message }}</strong></p>
		</div>
	</div>
@endif

@if ($message = Session::get('error'))
	<div class="uk-container uk-margin-top">
		<div class="uk-alert-danger" uk-alert>
			<a class="uk-alert-close" uk-close></a>
			<p><strong>{{ $message }}</strong></p>
		</div>
	</div>
@endif

@if ($errors->any())
	@foreach ($errors->all() as $error)
	<div class="uk-container uk-margin-top">
		<div class="uk-alert-danger" uk-alert>
			<a class="uk-alert-close" uk-close></a>
			<p><strong>{{ $error }}</strong></p>
		</div>
	</div>
	@endforeach
@endif
