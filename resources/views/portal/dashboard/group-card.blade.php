@if(!$groups->count())
 <div class="alert alert-warning mb-0 p-3 text-dark">
  <i class="boxcon fad fa-users text-warning"></i>
  <h4 class="text-xl-center mb-3 strong">
   User Groups
  </h4>
  <div class="text-xl-center poppins">
   You do not have a group, create your first user group
  </div>
 </div>
 <a href="{{ route('eac.portal.user.group.create') }}" class="btn btn-dark border-0 btn-block h5 mb-0 p-0">
  <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
   <span>Add User Group</span>
   <span class="fa-fw fad fa-lg fa-users"></span>
  </div>
 </a>
@else
 <div class="card">
  @if(\Auth::user()->type->name == 'Early Access Care')
   {{-- <div class="poppins alert-info p-2 small">
    <span class="fa-check-circle fad fa-fw fa-lg text-info"></span> No Users without Groups
   </div> --}}
   <a href="{{route('eac.portal.user.group.list')}}">
    <div class="poppins alert-warning p-2 small">
     <span class="fa-exclamation-triangle fad fa-fw fa-lg text-warning"></span> 2 Users without Groups
    </div>
   </a>
  @endif
  <div class="card-body p-3">
   <i class="boxcon fad fa-users text-secondary"></i>
   <div class="row">
    <div class="col mb-1 mb-md-3 @if(\Auth::user()->type->name !== 'Early Access Care') text-xl-center @endif">
     <a href="{{route('eac.portal.user.group.list')}}" class="h4 mb-0" title="View All User Groups">
      <strong>{{$groups->count()}}</strong>
      User Groups
     </a>
    </div>
    @if(\Auth::user()->type->name == 'Early Access Care')
     <div class="col-auto mb-3">
      <a class="badge text-dark" data-toggle="collapse" title="Expand User Details" href="#showGROUPstats" role="button" aria-expanded="false" aria-controls="showGROUPstats">
       Show Details
      </a>
     </div>
    @endif
   </div><!-- /.row -->
   <div class="text-xl-center poppins">
    Establish user groups within your practice/hospital
   </div>
   @if(\Auth::user()->type->name == 'Early Access Care')
    <div class="collapse" id="showGROUPstats">
     <ul class="list-group list-group-flush mb-0 small">
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.user.group.list')}}" title="View All User Groups">
        <div class="row m-0">
         <div class="col p-0">
          Physician Groups
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           #
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.user.group.list')}}" title="View All User Groups">
        <div class="row m-0">
         <div class="col p-0">
          Pharmaceutical Groups
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           #
          </span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.user.group.list')}}" title="View All User Groups">
        <div class="row m-0">
         <div class="col p-0">
          Early Access Care Groups
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">
           #
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
    <a class="btn btn-link btn-sm" href="{{route('eac.portal.user.group.list')}}" title="View All User Groups">
     View All User Groups <span class="fal fa-long-arrow-right"></span>
    </a>
   </div>
  </div>
  <a href="{{ route('eac.portal.user.group.create') }}" class="btn btn-light border-0 btn-block h5 mb-0 p-0" title="Create User Groups">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Create User Group</span>
    <span class="fa-fw fad fa-lg fa-users"></span>
   </div>
  </a>
 </div>
@endif
