<div class="card">
  <div class="bg-danger text-white p-2 small">
   <span class="fas fa-exclamation-triangle text-warning"></span> 2 Pending Physicians
  </div>
	<div class="card-body">
  <div class="d-flex justify-content-between">
   <div class="mb-3">
    <span class="h5 mb-0 d-block">
     <i class="fa-fw fa-lg fad fa-users text-warning"></i>
     <a class="text-dark" href="{{route('eac.portal.user.list')}}">Platform Users</a>
    </span>
   </div>
   <a class="btn btn-link btn-sm" data-toggle="collapse" href="#showUSERstats" role="button" aria-expanded="false" aria-controls="showUSERstats">
    Show Details
   </a>
  </div>
  <p class="text-muted mb-0 small text-xl-center">
   Create and manage all user types within the Early Access Care&trade; platform.
  </p>
  <div class="collapse ml-n3 mb-n3 mr-n3 mt-1 mark" id="showUSERstats">
   work in progress
   <ul class="list-group list-group-flush mb-0 small">
    {{--

        <li class="">
         <a href="{{route('eac.portal.user.list','user_status='.'Pending')}}"
            class="text-danger">
          <div class="row m-0">
           <div class="col p-0">
            Pending
            <i class="fas fa-exclamation-triangle text-danger"></i>
           </div>
           <div class="col-auto p-0">
            @php $pending_user = \EAC\User::where('status','Pending')->count(); @endphp
            <span
             class="badge badge-danger">@if($pending_user > 0) {{$pending_user}} @else
              0 @endif</span>
           </div>
          </div><!-- /.row -->
         </a>
        </li>
        <li class="">
         <a data-toggle="collapse" href="#showUsers" role="button" aria-expanded="true"
            aria-controls="showUsers">
          <div class="row m-0">
           <div class="col p-0">
            Approved
           </div>
           <div class="col-auto p-0">
            <i class="far fa-chevron-down"></i>
           </div>
          </div><!-- /.row -->
         </a>
         <div class="collapse show" id="showUsers">
          <ul class="list-unstyled m-0">
           @php
            $users = \EAC\UserType::where('user_types.id','!=','')
              ->LeftJoin('users','users.type_id','=','user_types.id')
              ->groupBy('user_types.id')
              ->where('users.status','Approved')
              ->select(DB::raw("count(users.id) as total"),'user_types.name as type_name','user_types.id as type_id')
              ->get();

           @endphp
           @if($users->count() > 0)
            @foreach($users as $val)
             <li class="pt-0 pr-0 pl-3 pl-xl-4 pb-1">
              <a href="{{route('eac.portal.user.list','user_status='.'Approved&user_type='.$val->type_id)}}">
               <div class="row m-0">
                <div class="col p-0">
                 {{ $val->type_name }} Users
                </div>
                <div class="col-auto p-0">
                 <span class="badge badge-light">
                  {{ $val->total }}
                 </span>
                </div>
               </div><!-- /.row -->
              </a>
             </li>
            @endforeach
           @endif
           --}}
   </ul>
  </div>
	</div>
 <a href="{{route('eac.portal.user.list')}}" class="btn btn-warning border-0 btn-block h5 mb-0 p-0 d-flex justify-content-between align-items-stretch">
  <div class="p-1 pl-2 pr-2 p-xl-3 alert-warning">
   {{$users->count()}}
  </div>
  <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center flex-fill">
   <span>Platform Users</span>
   <span class="fa-fw fas fa-lg fa-users"></span>
  </div>
 </a>
</div>