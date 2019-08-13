@if(!$drugs->count())
	<div class="bg-white border border-light p-3 h-100">
		<h4 class="strong">
			<a href="{{ route('eac.portal.drug.create') }}">Investigative Drugs</a>
		</h4>
		<p class="flex-grow-1 mb-3">
			You do not have any drugs, create one now </p>
		<a href="{{ route('eac.portal.drug.create') }}" class="btn btn-sm btn-secondary">Create Drug</a>
	</div>
@else
	<div class="card">
  <div class="bg-danger text-white p-2 small">
   <a href="{{route('eac.portal.drug.list')}}" class="text-white"><span class="fas fa-exclamation-triangle text-warning"></span> 5 Pending Drugs</a>
  </div>
		<div class="card-body">
   <div class="d-flex justify-content-between">
    <div class="mb-3">
     <span class="h5 mb-0 d-block">
      <i class="fa-fw fa-lg fad fa-prescription-bottle-alt text-secondary"></i>
      <a class="text-dark" href="{{route('eac.portal.drug.list')}}">Investigative Drugs</a>
     </span>
    </div>
    <a class="btn btn-link btn-sm" data-toggle="collapse" href="#showDRUGstats" role="button" aria-expanded="false" aria-controls="showDRUGstats">
     Show Details
    </a>
   </div>
			<p class="text-muted mb-0 small text-xl-center">
				Manage the investigative drugs available within<br />the Early Access Care&trade; platform
   </p>
   <div class="collapse ml-n3 mb-n3 mr-n3 mt-1 mark" id="showDRUGstats">
    <ul class="list-group list-group-flush mb-0 small">
     <li class="list-group-item pt-1 pb-1">
      <a href="{{route('eac.portal.drug.list')}}">
       <div class="row m-0">
        <div class="col p-0">
         Not Approved
        </div>
        <div class="col-auto p-0">
         <span class="badge badge-light">
          0
         </span>
        </div>
       </div><!-- /.row -->
      </a>
     </li>
     <li class="list-group-item pt-1 pb-1">
      <a href="{{route('eac.portal.drug.list')}}">
       <div class="row m-0">
        <div class="col p-0">
         Pending
        </div>
        <div class="col-auto p-0">
         <span class="badge badge-light">
          5
         </span>
        </div>
       </div><!-- /.row -->
      </a>
     </li>
     <li class="list-group-item pt-1 pb-1">
      <a href="{{route('eac.portal.drug.list')}}">
       <div class="row m-0">
        <div class="col p-0">
         Approved
        </div>
        <div class="col-auto p-0">
         <span class="badge badge-light">
          5
         </span>
        </div>
       </div><!-- /.row -->
      </a>
     </li>
    </ul>
   </div>
		</div>
  <a href="{{route('eac.portal.drug.list')}}" class="btn btn-light border-0 btn-block h5 mb-0 p-0 d-flex justify-content-between align-items-stretch">
   <div class="p-1 pl-2 pr-2 p-xl-3 alert-light">
    {{$drugs->count()}}
   </div>
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center flex-fill">
    <span>Investigative Drugs</span>
    <span class="fa-fw fas fa-lg fa-prescription-bottle-alt"></span>
   </div>
  </a>
	</div>
@endif