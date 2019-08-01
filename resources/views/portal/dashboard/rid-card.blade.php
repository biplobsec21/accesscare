@if(!$rids->count())
	<div class="bg-white border border-light p-3 h-100">
		<h4 class="strong">
			<a href="{{ route('eac.portal.rid.create') }}">Requests</a>
		</h4>
		<p class="flex-grow-1 mb-3">
			You do not have any requests, initiate one now </p>
		<a href="{{ route('eac.portal.rid.create') }}" class="btn btn-sm btn-primary">Initiate Request</a>
	</div>
@else
	<div class="card">
		<div class="card-body">
			<h5 class="text-xl-center">
				<i class="fa-fw fa-lg fad fa-medkit text-primary"></i>
				<a class="text-dark" href="{{route('eac.portal.rid.list')}}">Requests</a>
			</h5>
			<p class="text-muted mb-0 small text-xl-center">
				"Initiate New Request" initiates a drug order for investigational drug.
   </p>
		</div>
  <a href="{{ route('eac.portal.rid.create') }}" class="btn btn-primary border-0 btn-block h5 mb-0 p-0">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Initiate New Request</span>
    <span class="fa-fw fas fa-lg fa-medkit"></span>
   </div>
  </a>
	</div>
@endif