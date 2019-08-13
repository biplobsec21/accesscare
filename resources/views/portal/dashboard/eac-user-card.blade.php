<div class="card">
 <div class="bg-danger text-white p-2 small">
  <a href="{{route('eac.portal.user.list')}}" class="text-white"><span class="fas fa-exclamation-triangle text-secondary"></span> 2 Pending Physicians</a>
 </div>
	<div class="card-body">
  <div class="d-flex justify-content-between">
   <div class="mb-3">
    <span class="h5 mb-0 d-block">
     <i class="fa-fw fa-lg fad fa-users text-secondary"></i>
     <a class="text-dark" href="{{route('eac.portal.user.list')}}">Platform Users</a>
    </span>
   </div>
   <a class="btn btn-link btn-sm" data-toggle="collapse" href="#showUSERstats" role="button" aria-expanded="false" aria-controls="showUSERstats">
    Show Details
   </a>
  </div>
  <p class="text-muted mb-0 small text-xl-center">
   Create and manage all user types within<br />the Early Access Care&trade; platform.
  </p>
  <div class="collapse ml-n3 mb-n3 mr-n3 mt-1 mark" id="showUSERstats">
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
	</div>
 <a href="{{route('eac.portal.user.list')}}" class="btn btn-light border-0 btn-block h5 mb-0 p-0 d-flex justify-content-between align-items-stretch">
  <div class="p-1 pl-2 pr-2 p-xl-3 alert-light">
   {{$users->count()}}
  </div>
  <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center flex-fill">
   <span>Platform Users</span>
   <span class="fa-fw fas fa-lg fa-users"></span>
  </div>
 </a>
</div>