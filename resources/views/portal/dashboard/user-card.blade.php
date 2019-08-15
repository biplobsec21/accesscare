@if(!$users->count())
 <div class="alert alert-warning mb-0 p-3 text-dark">
  <i class="boxcon fad fa-user-md text-warning"></i>
  <h4 class="text-xl-center mb-3 strong">
   Users
  </h4>
  <div class="text-xl-center poppins">
   There are no users within the Platform
  </div>
 </div>
 <a href="{{ route('eac.portal.user.create') }}" class="btn btn-dark border-0 btn-block h5 mb-0 p-0">
  <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
   <span>Add User</span>
   <span class="fa-fw fad fa-lg fa-user-md"></span>
  </div>
 </a>
@else
 <div class="card">
  @if(\Auth::user()->type->name == 'Early Access Care')
   {{-- <div class="poppins alert-info p-2 small">
    <span class="fa-check-circle fad fa-fw fa-lg text-info"></span> No Pending Physicians
   </div> --}}
   <a href="{{route('eac.portal.user.list')}}">
    <div class="poppins alert-warning p-2 small">
     <span class="fa-exclamation-triangle fad fa-fw fa-lg text-warning"></span> 2 Pending Physicians
    </div>
   </a>
  @endif
  <div class="card-body p-3">
   <i class="boxcon fad fa-user-md text-secondary"></i>
   <div class="row">
    <div class="col mb-1 mb-md-3 @if(\Auth::user()->type->name !== 'Early Access Care') text-xl-center @endif">
     <a href="{{route('eac.portal.user.list')}}" class="h4 mb-0" title="View All Users">
      <strong>{{$users->count()}}</strong>
      Users
     </a>
    </div>
    @if(\Auth::user()->type->name == 'Early Access Care')
     <div class="col-auto mb-3">
      <a class="badge text-dark" data-toggle="collapse" title="Expand User Details" href="#showUSERstats" role="button" aria-expanded="false" aria-controls="showUSERstats">
       Show Details
      </a>
     </div>
    @endif
   </div><!-- /.row -->
   <div class="text-xl-center poppins">
    Create and manage all user types within the platform.
   </div>
   @if(\Auth::user()->type->name == 'Early Access Care')
    <div class="collapse" id="showUSERstats">
     <ul class="list-group list-group-flush mb-0 small">
      <li class="list-group-item pt-1 pb-1 text-danger">
       <a href="{{route('eac.portal.user.list')}}">
        <div class="row m-0">
         <div class="col p-0">
          Pending
          <i class="fas fa-exclamation-triangle text-danger"></i>
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-danger">17</span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.user.list')}}">
        <div class="row m-0">
         <div class="col p-0">
          Registering
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">5</span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.user.list')}}">
        <div class="row m-0">
         <div class="col p-0">
          Approved
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">81</span>
         </div>
        </div><!-- /.row -->
       </a>
       <ul class="list-unstyled small ml-3 mb-0">
        <li class="pt-1 pb-1">
         <a href="{{route('eac.portal.user.list')}}">
          <div class="row m-0">
           <div class="col p-0">
            Physician Users
           </div>
           <div class="col-auto p-0">
            <span class="badge badge-light">
             50
            </span>
           </div>
          </div><!-- /.row -->
         </a>
        </li>
        <li class="pt-1 pb-1">
         <a href="{{route('eac.portal.user.list')}}">
          <div class="row m-0">
           <div class="col p-0">
            Pharmaceutical Users
           </div>
           <div class="col-auto p-0">
            <span class="badge badge-light">
             17
            </span>
           </div>
          </div><!-- /.row -->
         </a>
        </li>
        <li class="pt-1 pb-1">
         <a href="{{route('eac.portal.user.list')}}">
          <div class="row m-0">
           <div class="col p-0">
            Early Access Care Users
           </div>
           <div class="col-auto p-0">
            <span class="badge badge-light">
             14
            </span>
           </div>
          </div><!-- /.row -->
         </a>
        </li>
       </ul>
      </li>
      <li class="list-group-item pt-1 pb-1">
       <a href="{{route('eac.portal.user.list')}}">
        <div class="row m-0">
         <div class="col p-0">
          Suspended
         </div>
         <div class="col-auto p-0">
          <span class="badge badge-light">3</span>
         </div>
        </div><!-- /.row -->
       </a>
      </li>
     </ul>
    </div>
   @endif
   <div class="mt-3 d-flex justify-content-between flex-wrap">
    <div><!-- empty --></div>
    <a class="btn btn-link btn-sm" href="{{route('eac.portal.user.list')}}">
     View All Users <span class="fal fa-long-arrow-right"></span>
    </a>
   </div>
 	</div>
  <a href="{{ route('eac.portal.user.create') }}" class="btn btn-light border-0 btn-block h5 mb-0 p-0">
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center">
    <span>Create User</span>
    <span class="fa-fw fad fa-lg fa-user-md"></span>
   </div>
  </a>
 </div>
@endif