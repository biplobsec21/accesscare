@if(!$drugs->count())
	<div class="bg-white border border-light p-3 h-100">
		<h4 class="strong">
			<a href="{{ route('eac.portal.drug.create') }}">Drugs</a>
		</h4>
		<p class="flex-grow-1 mb-3">
			You do not have any drugs, create one now </p>
		<a href="{{ route('eac.portal.drug.create') }}" class="btn btn-sm btn-info">Create Drug</a>
	</div>
@else
	<div class="card">
		<div class="card-body">
			<h5 class="text-xl-center">
				<i class="fa-fw fas fa-prescription-bottle-alt text-info"></i>
				<a class="text-dark" href="{{route('eac.portal.drug.list')}}">Drugs</a>
			</h5>
			<p class="text-muted mb-0 small text-xl-center">
				Manage the investigative drugs available within the Early Access Care&trade; platform
   </p>
		</div>
  <a href="{{route('eac.portal.drug.list')}}" class="btn btn-info border-0 btn-block h5 mb-0 p-0 d-flex justify-content-between align-items-stretch">
   <div class="p-1 pl-2 pr-2 p-xl-3 alert-info">
    {{$drugs->count()}}
   </div>
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center flex-fill">
    <span>Investigative Drugs</span>
    <span class="fa-fw fas fa-prescription-bottle-alt"></span>
   </div>
  </a>
	</div>
@endif