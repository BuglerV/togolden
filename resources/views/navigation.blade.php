<nav class="bg-dark p-2 px-4 text-light d-flex justify-content-between">
    <div>
		@include('logo')
	</div>
    <div class="align-self-center fs-4">
		<a href="{{ route('company.index') }}" class="me-4 d-inline">
			<span class="mr-2">{{ __('Companies') }}</span>
		</a>
	  @auth
		<form method="POST" action="{{ route('logout') }}" x-data class="d-inline">
			@csrf

			<a href="{{ route('logout') }}" @click.prevent="$root.submit();">
			    <span class="mr-2 d-none d-sm-inline">{{ __('Logout') }}</span>
				<i class="fa fa-sign-out ml-2"></i>
			</a>
		</form>
	  @else
		<a href="{{ route('login') }}" class="me-4">
			<span class="mr-2 d-none d-md-inline">{{ __('Login') }}</span>
			<i class="fa fa-sign-in ml-2"></i>
		</a>
		<a href="{{ route('register') }}">
			<span class="mr-2 d-none d-md-inline">{{ __('Registration') }}</span>
			<i class="fa fa-user-plus ml-2"></i>
		</a>
	  @endauth
	</div>
</nav>