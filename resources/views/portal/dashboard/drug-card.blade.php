@if(!$drugs->count())
	<div class="bg-white border border-light p-3 h-100">
		<h4 class="strong">
			<a href="{{ route('eac.portal.drug.create') }}">Drugs</a>
		</h4>
		<p class="flex-grow-1 mb-3">
			You do not have any drugs, create one now </p>
		<a href="{{ route('eac.portal.drug.create') }}" class="btn btn-sm btn-primary">Create Drug</a>
	</div>
@else
	<div class="card">
		<div class="card-body">
			<h5 class="text-xl-center">
				<i class="fa-fw fas fa-prescription-bottle-alt text-primary"></i>
				<a class="text-dark" href="{{route('eac.portal.drug.list')}}">Drugs</a>
			</h5>
			<p class="text-muted mb-0 small text-xl-center">
				Manage the Investigative drugs your company offers </p>
		</div>
		<div class="d-flex">
			<div class="p-3 h4 mb-0 alert-primary">
				<a href="{{route('eac.portal.drug.list')}}" class="text-nowrap text-primary">{{$drugs->count()}}</a>
			</div>
			<a href="{{ route('eac.portal.drug.create') }}" class="btn btn-primary btn-block btn-lg d-flex justify-content-between align-items-center">
				Submit Drug
				<i class="fa-fw fas fa-prescription-bottle-alt"></i>
			</a>
		</div>
	</div>
@endif