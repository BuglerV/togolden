@extends('layouts.app')

@section('body')
  <div class="container pb-4" data-role="menu-navigator">
      <div class="row" id="companies-list">
		@foreach($companies as $company)
            @include('company.one')
		@endforeach
	  </div>
	  
	  @auth
		  <div class="btn btn-warning mt-3" data-type="companyNewOpen">{{ __('New company') }}</div>
		  
		  <div class="d-none">
			  @include('company.form')
		  </div>
	  @endauth
  </div>
@endsection