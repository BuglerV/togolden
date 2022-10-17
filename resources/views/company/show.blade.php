@extends('layouts.app')

@php
    $fields = [
	    'Title' =>'title',
		'INN' => 'inn',
		'Description' => 'description',
		'Director' => 'director',
		'Address' => 'address',
		'Phone' => 'phone',
	];
@endphp

@section('body')
  <div class="container mt-2 pt-3" data-role="menu-navigator" data-id="{{ $company->id }}">
	@foreach($fields as $key => $field)
      <div data-field="{{ $field }}" class="pb-4">
	      <div class="fs-6">
			@auth
			  @include('comment.button')
			@endauth
            <b>{{ __($key) }}</b>			
		  </div>
		  <span class="fs-6">
		      {{ $company->$field }}
		  </span>
		@auth
		  <div class="ms-4" id="comments-{{ $field }}">
			  @include('comment.field',['field' => $field])
		  </div>
		@endauth
	  </div>
    @endforeach
	<div class="pb-4" data-field="null">
		@auth
		    <div class="clearfix">
				@include('comment.button',['message' => 'Comment company'])
			</div>
		    <div id="comments-null">
				@include('comment.field',['field' => 'null'])
			</div>
		@endauth
	</div>
  </div>
  
    @auth
	  <div class="d-none">
		<form id="creationForm">
			<div class="mb-3">
				<input name="text" class="form-control" placeholder="{{ __('Text') }}">
				<span class="invalid-feedback" role="alert"></span>
			</div>
			<span class="btn btn-warning" data-type="commentSave">{{ __('Save') }}</span>
		</form>
	  </div>
	@endauth
@endsection
