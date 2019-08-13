@if(!$rids->count())
 <div class="bg-white border border-light p-3 h-100">
  <h4 class="strong">
   <a href="{{ route('eac.portal.rid.create') }}">Requests</a>
  </h4>
  <p class="flex-grow-1 mb-3">
   You do not have any requests, initiate one now </p>
  <a href="{{ route('eac.portal.rid.create') }}" class="btn btn-sm btn-secondary">Initiate Request</a>
 </div>
@else
 <div class="card">
  <div class="bg-danger text-white p-2 small">
   <a href="{{route('eac.portal.rid.list')}}" class="text-white"><span class="fas fa-exclamation-triangle text-warning"></span> 8 New Requests</a>
  </div>
  <div class="card-body">
   <div class="d-flex justify-content-between">
    <div class="mb-3">
     <span class="h5 mb-0 d-block">
      <i class="fa-fw fa-lg fad fa-medkit text-secondary"></i>
      <a class="text-dark" href="{{route('eac.portal.rid.list')}}">Requests</a>
     </span>
    </div>
    <a class="btn btn-link btn-sm" data-toggle="collapse" href="#showRIDstats" role="button" aria-expanded="false" aria-controls="showRIDstats">
     Show Details
    </a>
   </div>
   <p class="text-muted mb-0 small text-xl-center">
    "Initiate New Request" initiates a drug order<br /> for investigational drug.
   </p>
   <div class="collapse ml-n3 mb-n3 mr-n3 mt-1 mark" id="showRIDstats">
    <ul class="list-group list-group-flush mb-0 small">
     @if($rids->count() > 0)
      <li class="list-group-item pt-1 pb-1 text-danger">
       <a href="{{route('eac.portal.rid.list')}}">
        <div class="row m-0">
         <div class="col p-0">
          New
           <i class="fas fa-exclamation-triangle text-danger"></i>
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-danger">
           8
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.rid.list')}}">
        <div class="row m-0">
         <div class="col p-0">
          Pending
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           24
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.rid.list')}}">
        <div class="row m-0">
         <div class="col p-0">
          Fulfillment
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           15
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.rid.list')}}">
        <div class="row m-0">
         <div class="col p-0">
          Completed
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           4
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.rid.list')}}">
        <div class="row m-0">
         <div class="col p-0">
          Approved
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           2
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
     @endif
    </ul>
   </div>
  </div>
  <a href="{{ route('eac.portal.rid.create') }}" class="btn btn-light border-0 btn-block h5 mb-0 p-0">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Initiate New Request</span>
    <span class="fa-fw fas fa-lg fa-medkit"></span>
   </div>
  </a>
 </div>
@endif