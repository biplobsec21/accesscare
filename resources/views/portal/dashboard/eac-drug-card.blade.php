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
  <div class="poppins bg-gradient-primary text-white p-2 small">
   <span class="fa-check-circle fad fa-fw fa-lg"></span> No Pending Drugs
  </div>
  {{-- <div class="poppins bg-gradient-warning text-dark p-2 small">
   <span class="fa-exclamation-triangle fad fa-fw fa-lg"></span> <a href="{{route('eac.portal.drug.list')}}" class="text-dark">5 Pending Drugs</a>
  </div> --}}
		<div class="card-body">
   <div class="d-flex justify-content-between">
    <div class="mb-3">
     <span class="h5 mb-0 d-block">
      <i class="fa-fw fa-lg fad fa-prescription-bottle-alt text-secondary"></i>
      <strong>{{$drugs->count()}}</strong>
      <a class="text-dark" href="{{route('eac.portal.drug.list')}}">Investigative Drugs</a>
     </span>
    </div>
    <a class="btn btn-link btn-sm" data-toggle="collapse" href="#showDRUGstats" role="button" aria-expanded="false" aria-controls="showDRUGstats">
     Show Details
    </a>
   </div>
			<p class="text-muted mb-0 small text-xl-center">
				Manage the investigative drugs available within the platform
   </p>
   <div class="collapse ml-n3 mr-n3 mt-1 mark" id="showDRUGstats">
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
   <div class="mt-3 d-flex justify-content-between flex-wrap">
    <div><!-- empty --></div>
    <a class="btn btn-link btn-sm" href="{{route('eac.portal.drug.list')}}">
     View All Drugs <span class="fal fa-long-arrow-right"></span>
    </a>
   </div>
		</div>
  <a href="{{ route('eac.portal.drug.create') }}" class="btn btn-light border-0 btn-block h5 mb-0 p-0">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Add New Drug</span>
    <span class="fa-fw fad fa-lg fa-prescription-bottle-alt"></span>
   </div>
  </a>
	</div>
@endif