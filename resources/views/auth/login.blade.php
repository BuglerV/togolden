@extends('layouts.guest')

@section('body')

<div class="d-flex justify-content-center min-vh-100 align-items-center">
    <div class="w-100">
	    <div class="text-center fs-1 mb-2" style="text-size">
		    @include('logo')
		</div>
		<div class="text-light">
			<div class="card-body">
				<form method="POST" action="{{ route('login') }}">
					@csrf
				  
					<div class="">
						<label for="email" class="col-form-label offset-sm-3 col-9 offset-1">{{ __('Email') }}</label>

						<div class="col-sm-6 offset-sm-3 offset-1 col-10">
							<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>

							@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>
				  
					<div class="">
						<label for="password" class="col-form-label offset-sm-3 col-9 offset-1">{{ __('Password') }}</label>

						<div class="col-sm-6 offset-sm-3 offset-1 col-10">
							<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

							@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>
					
					<div class="my-3">
						<label for="remember" class="d-inline col-form-label offset-sm-3 offset-1">{{ __('Remember me') }}</label>

						<span class="mt-2">
							<input id="remember" type="checkbox" name="remember" class="form-check-input" value="{{ old('remember') }}">
						</span>
					</div>
				  
					<div class="">
						<div class="col-11 col-sm-9 text-end">
						    <a href="{{ route('password.request') }}" class="me-4 text-decoration-underline">{{ __('Forgotten password?') }}</a>
							<button type="submit" class="btn btn-warning">
								{{ __('Login') }}
							</button>
						</div>
					</div>
				  
				</form>
			</div>
		</div>
	</div>

@endsection