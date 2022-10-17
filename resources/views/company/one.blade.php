  <div class="col-lg-4 col-md-6 col-sm-12 p-2" id="company_{{ $company->id }}" data-id="{{ $company->id }}">
	<div>
	  @auth
		  <span class="float-end">
			<a href="{{ route('company.destroy',$company) }}" data-type="deleteCompany"><i class="fa fa-trash text-danger"></i></a>
		  </span>
	  @endauth
	  <a href="{{ route('company.show',$company) }}">
		<b data-name data-fill="title">{{ $company->title }}</b>
	  </a>
	</div>
	<div>{{ __('Address') }}: <span data-fill="address">{{ $company->address }}</span></div>
	<div>{{ __('Phone') }}: <span data-fill="phone">{{ $company->phone }}</span></div>
	<div>{{ __('Director') }}: <span data-fill="director">{{ $company->director }}</span></div>
  </div>