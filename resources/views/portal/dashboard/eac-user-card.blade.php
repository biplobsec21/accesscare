<div class="card">
 {{-- <div class="poppins bg-gradient-primary text-white p-2 small">
  <span class="fa-check-circle fad fa-fw fa-lg"></span> No Pending Physicians
 </div> --}}
 <a href="{{route('eac.portal.user.list')}}" class="text-dark">
  <div class="poppins bg-gradient-warning p-2 small">
   <span class="fa-exclamation-triangle fad fa-fw fa-lg"></span> 2 Pending Physicians
  </div>
 </a>
	<div class="card-body">
  <div class="d-flex justify-content-between">
   <div class="mb-3">
    <span class="h5 mb-0 d-block">
     <i class="fa-fw fa-lg fad fa-users text-secondary"></i>
     <strong>{{$users->count()}}</strong>
     <a class="text-dark" href="{{route('eac.portal.user.list')}}">Platform Users</a>
    </span>
   </div>
   <a class="btn btn-link btn-sm" data-toggle="collapse" href="#showUSERstats" role="button" aria-expanded="false" aria-controls="showUSERstats">
    {{-- <span class="fal fa-plus fa-sm"></span> --}} Show Details
   </a>
  </div>
  <p class="text-muted mb-0 small text-xl-center">
   Create and manage all user types within the Early Access Care&trade; platform.
  </p>
  <div class="collapse ml-n3 mr-n3 mt-1 mark" id="showUSERstats">
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
   <span class="fa-fw fad fa-lg fa-users"></span>
  </div>
 </a>
</div>