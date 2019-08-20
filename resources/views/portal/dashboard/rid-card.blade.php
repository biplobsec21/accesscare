@if(!$rids->count())
 <div class="alert alert-primary mb-0 p-3 text-dark">
  <i class="boxcon fad fa-medkit text-primary"></i>
  <h4 class="text-xl-center mb-3 strong">
   Requests
  </h4>
  <div class="text-xl-center poppins">
   You do not have any requests, initiate one now
  </div>
 </div>
 <a href="{{ route('eac.portal.rid.create') }}" class="btn btn-primary border-0 btn-block h5 mb-0 p-0">
  <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
   <span>Initiate New Request</span>
   <span class="fa-fw fad fa-lg fa-medkit"></span>
  </div>
 </a>
@else
 <div class="card">
  @if(\Auth::user()->type->name == 'Early Access Care')
   {{-- <div class="poppins alert-info p-2 small">
    <span class="fa-check-circle fad fa-fw fa-lg text-info"></span> No New Requests
   </div> --}}
   <a href="{{route('eac.portal.rid.list')}}">
    <div class="poppins alert-warning p-2 small">
     <span class="fa-exclamation-triangle fad fa-fw fa-lg text-warning"></span> 8 New Requests
    </div>
   </a>
  @endif
  <div class="card-body p-3">
   <i class="boxcon fad fa-medkit text-secondary"></i>
   <div class="row">
    <div class="col mb-1 mb-md-3 @if(\Auth::user()->type->name !== 'Early Access Care') text-xl-center @endif">
     <a href="{{route('eac.portal.rid.list')}}" class="h4 mb-0" title="View All Requests">
      <strong>{{$rids->count()}}</strong>
      Requests
     </a>
    </div>
    @if(\Auth::user()->type->name == 'Early Access Care')
     <div class="col-auto mb-3">
      <a class="badge text-dark" data-toggle="collapse" title="Expand Request Details" href="#showRIDstats" role="button" aria-expanded="false" aria-controls="showRIDstats">
      Show Details
      </a>
     </div>
    @endif
   </div><!-- /.row -->
   <div class="text-xl-center poppins">
    "Initiate New Request" initiates a drug order for investigational drug.
   </div>
   @if(\Auth::user()->type->name == 'Early Access Care')
    <div class="collapse" id="showRIDstats">
     <ul class="list-group list-group-flush mb-0 small">
      @if($rids->count() > 0)
       <li class="list-group-item pt-1 pb-1 text-danger">
        <a href="{{route('eac.portal.rid.list') . "?status-name=New"}}">
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
        <a href="{{route('eac.portal.rid.list') . "?status-name=Pending"}}">
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
        <a href="{{route('eac.portal.rid.list') . "?status-name=Fulfillment"}}">
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
        <a href="{{route('eac.portal.rid.list') . "?status-name=Completed"}}">
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
        <a href="{{route('eac.portal.rid.list') . "?status-name=Approved"}}">
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
   @endif

   {{-- <div class="mt-2 d-flex justify-content-between flex-wrap mb-n1">
    <div>
     @if(\Auth::user()->type->name == 'Early Access Care')
       <a class="badge badge-light" data-toggle="collapse" title="Expand Request Details" href="#showRIDstats" role="button" aria-expanded="false" aria-controls="showRIDstats">
       More Details
       </a>
     @endif
    </div>
    <a class="btn btn-link btn-sm" href="{{route('eac.portal.rid.list')}}" title="View All Requests">
     View All Requests <span class="fal fa-long-arrow-right"></span>
    </a>
   </div> --}}

   <div class="mt-3 d-flex justify-content-between flex-wrap">
    <div><!-- empty --></div>
    <a class="btn btn-link btn-sm" href="{{route('eac.portal.rid.list')}}" title="View All Requests">
     View All Requests <span class="fal fa-long-arrow-right"></span>
    </a>
   </div>
  </div>
  <a href="{{ route('eac.portal.rid.create') }}" class="btn btn-primary border-0 btn-block h5 mb-0 p-0" title="Initiate New Request">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Initiate New Request</span>
    <span class="fa-fw fad fa-lg fa-medkit"></span>
   </div>
  </a>
 </div>
@endif
