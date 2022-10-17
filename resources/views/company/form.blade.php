<form id="creationForm">
	<input type="hidden" name="id">
	<div class="mb-3">
	    <input name="title" class="form-control" placeholder="{{ __('Title') }}">
		<span class="invalid-feedback" role="alert"></span>
	</div>
	<div class="mb-3">
	    <input name="director" class="form-control" placeholder="{{ __('Director') }}">
		<span class="invalid-feedback" role="alert"></span>
	</div>
	<div class="mb-3">
	    <input name="address" class="form-control" placeholder="{{ __('Address') }}">
		<span class="invalid-feedback" role="alert"></span>
	</div>
	<div class="mb-3">
	    <input name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="{{ __('Phone') }}">
		<span class="invalid-feedback" role="alert"></span>
	</div>
	<div class="mb-3">
	    <input name="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('Description') }}">
		<span class="invalid-feedback" role="alert"></span>
	</div>
	<div class="mb-3">
	    <input name="inn" class="form-control @error('inn') is-invalid @enderror" placeholder="{{ __('INN') }}">
		<span class="invalid-feedback" role="alert"></span>
	</div>
    <span class="btn btn-warning" data-type="companySave">{{ __('Save') }}</span>
</form>