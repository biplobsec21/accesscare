@if(!$drugs->count())
 <div class="alert alert-secondary mb-0 p-3">
  <i class="boxcon fad fa-capsules"></i>
  <h4 class="text-xl-center mb-3">
   Drugs
  </h4>
  <div class="text-xl-center poppins">
   You do not have any drugs, create one now
  </div>
 </div>
 <a href="{{ route('eac.portal.drug.create') }}" class="btn btn-dark border-0 btn-block h5 mb-0 p-0">
  <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
   <span>Add Drug</span>
   <span class="fa-fw fad fa-lg fa-capsules"></span>
  </div>
 </a>
@else
 <div class="card">
  @if(\Auth::user()->type->name == 'Early Access Care')
   <div class="poppins alert-info p-2 small">
    <span class="fa-check-circle fad fa-fw fa-lg text-info"></span> No Pending Drugs
   </div>
   {{-- <a href="{{route('eac.portal.drug.list')}}">
    <div class="poppins alert-warning p-2 small">
     <span class="fa-exclamation-triangle fad fa-fw fa-lg text-warning"></span> 2 Pending Drugs
    </div>
   </a> --}}
  @endif
  <div class="card-body p-3">
   <i class="boxcon fad fa-capsules text-secondary"></i>
   <div class="row">
    <div class="col mb-1 mb-md-3 @if(\Auth::user()->type->name !== 'Early Access Care') text-xl-center @endif">
     <a href="{{route('eac.portal.drug.list')}}" class="h4 mb-0 " title="View All Drugs">
      <strong>{{$drugs->count()}}</strong>
      Drugs
     </a>
    </div>
    @if(\Auth::user()->type->name == 'Early Access Care')
     <div class="col-auto mb-3">
      <a class="badge text-dark" data-toggle="collapse" title="Expand Drug Details" href="#showDRUGstats" role="button" aria-expanded="false" aria-controls="showDRUGstats">
       Show Details
      </a>
     </div>
    @endif
   </div><!-- /.row -->
   <div class="text-xl-center poppins">
    Manage investigative drugs within the platform
   </div>
   @if(\Auth::user()->type->name == 'Early Access Care')
    <div class="collapse" id="showDRUGstats">
     <ul class="list-group list-group-flush mb-0 small">
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.drug.list') . "?status=Not%20Approved"}}">
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
       <a href="{{route('eac.portal.drug.list') . "?status=Pending"}}">
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
       <a href="{{route('eac.portal.drug.list') . "?status=Approved"}}">
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
   @endif
   <div class="mt-3 d-flex justify-content-between flex-wrap">
    <div><!-- empty --></div>
    <a class="btn btn-link btn-sm" href="{{route('eac.portal.drug.list')}}">
     View All Drugs <span class="fal fa-long-arrow-right"></span>
    </a>
   </div>
  </div>
  <a href="{{ route('eac.portal.drug.create') }}" class="btn btn-light border-0 btn-block h5 mb-0 p-0">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Add Drug</span>
    <span class="fa-fw fad fa-lg fa-capsules"></span>
   </div>
  </a>
 </div>
@endif
