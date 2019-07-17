@extends('layouts.portal')

@section('title')
	Dashboard
@endsection

@section('content')
 <h3 class="mb-3 mb-xl-4">
  Welcome to your <strong>Dashboard</strong>, <span class="text-info">{{\Auth::user()->first_name}}</span>
 </h3>

 <div class="row">
  @if(\Auth::user()->type->name != 'Pharmaceutical')
   <div class="col-lg-3 mb-3">
    <div class="card">
     <div class="card-body p-2">
      <div class="@if(\Auth::user()->type->name == 'Early Access Care') d-flex justify-content-between @else text-center @endif">
       <h5 class="mb-0">
        <i class="fa-fw fas fa-medkit text-primary"></i> <a class="text-dark" href="{{route('eac.portal.rid.list')}}">Requests</a>
       </h5>
       @if((\Auth::user()->type->name == 'Early Access Care') && ($rids->count() > 0))
        <a data-toggle="collapse" class="btn btn-link text-muted btn-sm" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
         <span class="fal fa-angle-down"></span> Expand Data
        </a>
       @endif
      </div>
     </div>

     @if(!$rids->count() > 0)
      <div class="card-body mark p-3 strong small text-center">
       You do not have any RIDs, initiate your first request now
      </div>
     @endif
     <div class="row m-0 align-items-center">
      @if($rids->count() > 0)
       <div class="col-auto bg-primary text-white p-3 h4 mb-0 strong">
        {{ $rids->count()}}
       </div>
      @endif
      <div class="col p-0">
       <a href="{{ route('eac.portal.rid.create') }}" class="btn btn-primary btn-lg btn-block @if($rids->count() > 0) text-left @endif">
        <span class="fas fa-medkit"></span> Initiate New Request
       </a>
      </div>
     </div>
     @if((\Auth::user()->type->name == 'Early Access Care') && ($rids->count() > 0))
      <div class="collapse multi-collapse" id="multiCollapseExample1">
       <ul class="list-group list-group-flush">
        @foreach(\App\RidMasterStatus::all() as $status)
         <li class="list-group-item d-sm-flex justify-content-between">
          <a href="{{route('eac.portal.rid.list','rid_status=' . $status->id)}}" class="@if($status->name == 'New')text-danger @endif">
           {{ $status->name }}
           @if($status->name == 'New') <span class="fas fa-exclamation-triangle"></span> @endif
          </a>
          <a href="{{route('eac.portal.rid.list','rid_status=' . $status->id)}}" class="badge @if($status->name == 'New')badge-danger @else badge-light @endif">
           {{ $rids->where('status_id', $status->id)->count() }}
          </a>
         </li>
        @endforeach
       </ul>
      </div>
     @endif
     @if($rids->count() > 0)
      <div class="card-footer bg-transparent border-transparent p-2">
       <a href="{{route('eac.portal.rid.list')}}" class="btn btn-sm btn-link">
        <span class="fal fa-list-alt"></span> View All
       </a>
      </div>
     @endif
    </div>
   </div>
  @endif
  @if(\Auth::user()->type->name != 'Physician')
   <div class="col-lg-3 mb-3">
    <div class="card">
     <div class="card-header d-flex justify-content-between bg-transparent border-transparent p-2">
      <h5 class="mb-0 strong">Drugs</h5>
      @if(\Auth::user()->type->name == 'Early Access Care')
       <a data-toggle="collapse" class="btn btn-link text-muted btn-sm" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">
        <span class="fal fa-angle-down"></span> Expand Data
       </a>
      @endif
     </div>
     <div class="row m-0 align-items-center">
      <div class="col-auto bg-primary text-white p-3 h4 mb-0 strong">
       {{ $drugs->count() }}
      </div>
      <div class="col p-0">
       <a href="{{ route('eac.portal.drug.create') }}" class="btn btn-primary btn-lg btn-block text-left">
        <span class="fas fa-prescription-bottle-alt"></span> Add Drug
       </a>
      </div>
     </div>
     @if(\Auth::user()->type->name == 'Early Access Care')
      @php
       $approved = $drugs->where('status','Approved')->count();
       $notApproved = $drugs->where('status','Not Approved')->count();
       $pending = $drugs->where('status','Pending')->count();
      @endphp
      <div class="collapse multi-collapse" id="multiCollapseExample2">
       <ul class="list-group list-group-flush">
        <li class="list-group-item d-sm-flex justify-content-between">
         <a href="{{route('eac.portal.drug.list','drug_status='.'Pending')}}" class="@if($pending > 0) text-danger @endif">
          Pending @if($pending > 0) <span class="fas fa-exclamation-triangle"></span> @endif
         </a>
         <a href="{{route('eac.portal.drug.list','drug_status='.'Pending')}}" class="badge @if($pending > 0) badge-danger @else badge-light @endif">
          {{$pending}}
         </a>
        </li>
        <li class="list-group-item d-sm-flex justify-content-between">
         <a href="{{route('eac.portal.drug.list','drug_status='.'Approved')}}">
          Approved
         </a>
         <a href="{{route('eac.portal.drug.list','drug_status='.'Approved')}}" class="badge badge-light">
          {{$approved}}
         </a>
        </li>
        <li class="list-group-item d-sm-flex justify-content-between">
         <a href="{{route('eac.portal.drug.list','drug_status='.'Not Approved')}}">
          Not Approved
         </a>
         <a href="{{route('eac.portal.drug.list','drug_status='.'Not Approved')}}" class="badge badge-light">
          {{$notApproved}}
         </a>
        </li>
       </ul>
      </div>
     @endif
     <div class="card-footer bg-transparent border-transparent p-2">
      <a href="{{route('eac.portal.drug.list')}}" class="btn btn-sm btn-link">
       <span class="fal fa-list-alt"></span> View All
      </a>
     </div>
    </div>
   </div>
   <div class="col-lg-3 mb-3">
    <div class="card">
     <div class="card-header d-flex justify-content-between bg-transparent border-transparent p-2">
      <h5 class="mb-0 strong">Users</h5>
      @if(\Auth::user()->type->name == 'Early Access Care')
       <a data-toggle="collapse" class="btn btn-link text-muted btn-sm" href="#multiCollapseExample3" role="button" aria-expanded="false" aria-controls="multiCollapseExample3">
        <span class="fal fa-angle-down"></span> Expand Data
       </a>
      @endif
     </div>
     <div class="row m-0 align-items-center">
      <div class="col-auto bg-primary text-white p-3 h4 mb-0 strong">
       {{ $users->count() }}
      </div>
      <div class="col p-0">
       <a href="{{ route('eac.portal.user.create') }}" class="btn btn-primary btn-lg btn-block text-left">
        <span class="fas fa-user-md"></span> Add User
       </a>
      </div>
     </div>
     @if(\Auth::user()->type->name == 'Early Access Care')
      @php
       $pending_users = $users->where('status','Pending')->count();
       $approved_users = $users->where('status','Approved')->count();
       $suspended_users = $users->where('status','Suspended')->count();
       $approved_collection = collect($users->where('status','Approved')->groupBy(function ($user) {return json_encode($user->type);})->all());
      @endphp
      <div class="collapse multi-collapse" id="multiCollapseExample3">
       <ul class="list-group list-group-flush">
        <li class="list-group-item d-sm-flex justify-content-between">
         <a href="{{route('eac.portal.user.list','user_status='.'Pending')}}" class="@if($pending_users > 0) text-danger @endif">
          Pending <span class="fas fa-exclamation-triangle"></span>
         </a>
         <a href="{{route('eac.portal.user.list','user_status='.'Pending')}}" class="badge @if($pending_users > 0) badge-danger @else badge-light @endif">{{$pending_users}}</a>
        </li>
        <li class="list-group-item d-sm-flex justify-content-between">
         <a href="{{route('eac.portal.user.list','user_status='.'Approved')}}">
          Approved
         </a>
         <a href="{{route('eac.portal.user.list','user_status='.'Approved')}}" class="badge badge-light">{{$approved_users}}</a>
        </li>
        <li class="list-group-item d-sm-flex justify-content-between">
         <a href="{{route('eac.portal.user.list','user_status='.'Suspended')}}">
          Suspended
         </a>
         <a href="{{route('eac.portal.user.list','user_status='.'Suspended')}}" class="badge badge-light">{{$suspended_users}}</a>
        </li>
       </ul>
      </div>
     @endif
     <div class="card-footer bg-transparent border-transparent p-2">
      <a href="{{route('eac.portal.user.list')}}" class="btn btn-sm btn-link">
       <span class="fal fa-list-alt"></span> View All
      </a>
     </div>
    </div>
   </div>
  @endif
  <div class="col-lg-3 mb-3">
   <div class="card">
    <div class="card-header d-flex justify-content-between bg-transparent border-transparent p-2">
     <h5 class="mb-0 strong">User Groups &amp; Types</h5>
     @if((\Auth::user()->type->name == 'Early Access Care') && ((\Auth::user()->groups()->count() > 0) || ($approved_collection->count() > 0)))
      <a data-toggle="collapse" class="btn btn-link text-muted btn-sm" href="#multiCollapseExample4" role="button" aria-expanded="false" aria-controls="multiCollapseExample4">
       <span class="fal fa-angle-down"></span> Expand Data
      </a>
     @endif
    </div>
    @if(!\Auth::user()->groups()->count() > 0)
     <div class="card-body mark p-3 strong small text-center">
      You do not have any User Groups, please create your first group now
     </div>
    @endif
    <div class="row m-0 align-items-center">
     @if(\Auth::user()->groups()->count() > 0)
      <div class="col-auto bg-primary text-white p-3 h4 mb-0 strong">
       {{\Auth::user()->groups()->count()}}
      </div>
     @endif
     <div class="col p-0">
      <a href="{{ route('eac.portal.user.group.create') }}" class="btn btn-primary btn-lg btn-block @if(\Auth::user()->groups()->count() > 0) text-left @endif">
       <span class="fas fa-users"></span> Create User Group
      </a>
     </div>
    </div>
    @if(\Auth::user()->type->name == 'Early Access Care')
     <div class="collapse multi-collapse" id="multiCollapseExample4">
      <ul class="list-group list-group-flush">
       @if(\Auth::user()->groups()->count() > 0)
        <li class="list-group-item d-sm-flex justify-content-between">
         <a href="#">
          User Groups
         </a>
         <a href="#" class="badge badge-light">{{\Auth::user()->groups()->count()}}</a>
        </li>
       @endif
       @if($approved_collection->count() > 0)
        @foreach($approved_collection as $type => $user)
         <li class="list-group-item d-sm-flex justify-content-between">
          <a href="{{route('eac.portal.user.list','user_status='.'Approved&user_type='. json_decode($type)->id)}}">
           {{ json_decode($type)->name }} Users
          </a>
          <a href="{{route('eac.portal.user.list','user_status='.'Approved&user_type='. json_decode($type)->id)}}" class="badge badge-light">
           {{ $user->count() }}
          </a>
         </li>
        @endforeach
       @endif
      </ul>
     </div>
    @endif
    @if(\Auth::user()->groups()->count() > 0)
     <div class="card-footer bg-transparent border-transparent p-2">
      <a href="#{{route('eac.portal.user.group.list')}}" class="btn btn-sm btn-link">
       <span class="fal fa-list-alt"></span> View All User Groups
      </a>
     </div>
    @endif
   </div>
  </div>
 </div>
 @if(\Auth::user()->type->name == 'Early Access Care')
  <div class="card mb-1 mb-md-4">
   <div class="card-body pt-3 pl-3 pr-3 pb-0">
    <h5 class="text-primary strong text-upper mb-3">
     Requests Pending Fulfillment
    </h5>
   </div>
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover" id="ridAwaitingListTBL">
     <thead>
     <tr>
      <th class="no-search no-sort"></th>
      <th>RID Number</th>
      <th>Drug Requested</th>
      <th>Ship By</th>
      <th class="no-search no-sort"></th>
     </tr>
     </thead>
     <tbody></tbody>
     <tfoot>
     <tr>
      <th class="no-search no-sort"></th>
      <th>RID Number</th>
      <th>Drug Requested</th>
      <th>Ship By</th>
      <th class="no-search no-sort"></th>
     </tr>
     </tfoot>
    </table>
   </div>
  </div>
 @elseif(\Auth::user()->type->name == 'Physician')
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover" id="ridListTBL">
     <thead>
      <tr>
       <th>RID Number</th>
       <th>Master Status</th>
       <th>Assigned To</th>
       <th>Drug Requested</th>
       <th>Request Date</th>
       <th>Created At</th>
       <th></th>
      </tr>
     </thead>
     <tbody></tbody>
    </table>
   </div>
  </div>
 @elseif(\Auth::user()->type->name == 'Pharmaceutical')
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover" id="companyDrugListTBL">
     <thead>
     <tr>
      <th>Drug Name</th>
      <th>Status</th>
      <th>Submitted Date</th>
      <th></th>
     </tr>
     </thead>
     <tbody></tbody>
    </table>
   </div>
  </div> 
 @endif
  @if(\Auth::user()->type->name == 'Physician')
   <div class="row ">
    <div class="col-sm-6 col-xl mb-3 mb-xl-5">
     @if(!$rids->count())
      <div class="bg-white border border-light p-3 h-100">
       <h4 class="strong">
        <a href="{{ route('eac.portal.rid.create') }}">Requests</a>
       </h4>
       <p class="flex-grow-1 mb-3">
        You do not have any requests, initiate one now
       </p>
       <a href="{{ route('eac.portal.rid.create') }}" class="btn btn-sm btn-primary">Initiate Request</a>
      </div>
     @else
      <div class="card">
       <div class="card-body">
        <h5 class="text-xl-center">
         <i class="fa-fw fas fa-medkit text-primary"></i> <a class="text-dark" href="{{route('eac.portal.rid.list')}}">Requests</a>
        </h5>
        <p class="text-muted mb-0 small text-xl-center">
         "Initiate Request" initiates a drug order for investigational drug.
        </p>
       </div>
       <div class="d-flex">
        <div class="p-3 h4 mb-0 alert-primary">
         <a href="{{route('eac.portal.rid.list')}}" class="text-nowrap text-primary">{{$rids->count()}}</a>
        </div>
        <a href="{{ route('eac.portal.rid.create') }}" class="btn btn-primary btn-block btn-lg d-flex justify-content-between align-items-center">
         Initiate Request <i class="fa-fw fas fa-medkit"></i>
        </a>
       </div>
      </div>
     @endif
    </div>
    <div class="col-sm-6 col-xl mb-3 mb-xl-5">
     @if(!\Auth::user()->groups())
      <div class="bg-white border border-light p-3 h-100">
       <h4 class="strong">
        <a href="{{ route('eac.portal.user.group.create') }}">User Groups</a>
       </h4>
       <p class="flex-grow-1 mb-3">
        You do not have a group, create your user group
       </p>
       <a href="{{ route('eac.portal.user.group.create') }}" class="btn btn-sm btn-primary">Create Group</a>
      </div>
     @else
      <div class="card">
       <div class="card-body">
        <h5 class="text-xl-center">
         <i class="fa-fw fas fa-users text-info"></i> <a class="text-dark" href="{{route('eac.portal.user.group.list')}}">User Groups</a>
        </h5>
        <p class="text-muted mb-0 small text-xl-center">
         Establish your user groups within your practice/hospital
        </p>
       </div>
       <div class="d-flex">
        <div class="p-3 h4 mb-0 alert-info">
         <a href="{{route('eac.portal.user.group.list')}}" class="text-info">{{\Auth::user()->groups()->count()}}</a>
        </div>
        <a href="{{ route('eac.portal.user.group.create') }}" class="btn btn-info btn-block btn-lg d-flex justify-content-between align-items-center">
         View User Groups <i class="fa-fw fas fa-users"></i>
        </a>
       </div>
      </div>
     @endif
    </div>
    @if(\Auth::user()->notifications()->count() > 0)
     <div class="col-sm-6 col-xl mb-3 mb-xl-5">
      <div class="card">
       <div class="card-body">
        <h5 class="text-xl-center">
         <i class="fa-fw fas fa-bell text-success"></i> <a href="#" class="text-dark toggleRight">Notifications</a>
        </h5>
        <p class="text-muted mb-0 small text-xl-center">
         View your notifications within the Early Access Care&trade; platform
        </p>
       </div>
       <div class="d-flex">
        <div class="p-3 h4 mb-0 alert-success">
         <a href="#" class="toggleRight text-success">{{\Auth::user()->notifications()->count()}}</a>
        </div>
        <a href="#" class="toggleRight btn btn-success btn-block btn-lg d-flex justify-content-between align-items-center">
         Notifications <i class="fa-fw fas fa-bell"></i>
        </a>
       </div>
      </div>
     </div>
    @endif
    <div class="col-sm-6 col-xl mb-3 mb-xl-5">
     @if(\Auth::user()->hasDefaultPassword())
      <div class="bg-white border border-light p-3 h-100">
       <h4 class="strong">
        <a href="{{ route('eac.portal.user.create') }}">Modify Password</a>
       </h4>
       <p class="flex-grow-1 mb-3">
        Temporary password assigned, please update your password information
       </p>
       <a href="{{ route('eac.portal.user.edit', \Auth::user()->id) }}" class="btn btn-sm btn-primary">Upload Documents</a>
      </div>
     @else
      <div class="card">
       <div class="card-body">
        <h5 class="text-xl-center">
         <i class="fa-fw fas fa-user-md text-dark"></i> <a class="text-dark" href="{{ route('eac.portal.user.show', \Auth::user()->id) }}">Account Settings</a>
        </h5>
        <p class="text-muted mb-0 small text-xl-center">
         Manage professional documents and company address
        </p>
       </div>
       <a href="{{ route('eac.portal.user.show', \Auth::user()->id) }}" class="btn btn-dark btn-block btn-lg d-flex justify-content-between align-items-center">
        My Account <i class="fa-fw fas fa-user-md"></i>
       </a>
      </div>
     @endif
    </div>
    @if(!\Auth::user()->certificate)
     <div class="col-sm-6 col-xl mb-3 mb-xl-5">
      <div class="bg-white border border-light p-3 h-100">
       <h4 class="strong">
        <a href="{{ route('eac.portal.user.edit', \Auth::user()->id) }}">Professional Documents</a>
       </h4>
       <p class="flex-grow-1 mb-3">
        Please upload your medical documentation
       </p>
       <a href="{{ route('eac.portal.user.edit', \Auth::user()->id) }}" class="btn btn-sm btn-primary">Upload Documents</a>
      </div>
     </div>
    @endif
   </div>
   <div class="viewData">
    <div class="card mb-1 mb-md-4">
     <div class="table-responsive">
      <table class="table table-sm table-striped table-hover" id="ridListTBL">
       <thead>
        <tr>
         <th>RID Number</th>
         <th>Master Status</th>
         <th>Assigned To</th>
         <th>Drug Requested</th>
         <th>Request Date</th>
         <th>Created At</th>
         <th></th>
        </tr>
       </thead>
       <tbody></tbody>
      </table>
     </div>
    </div>
   </div>
  @elseif(\Auth::user()->type->name == 'Pharmaceutical')
   <div class="row">
    <div class="col-sm-4 mb-3 mb-xl-5">
     @if($drugs->count())
      <div class="bg-white border border-light p-3 h-100">
       <h4 class="strong">
        <a href="{{ route('eac.portal.drug.create') }}">Drugs</a>
       </h4>
       <p class="flex-grow-1 mb-3">
        You do not have any drugs, create one now
       </p>
       <a href="{{ route('eac.portal.drug.create') }}" class="btn btn-sm btn-primary">Create Drug</a>
      </div>
     @else
      <div class="card">
       <div class="card-body">
        <h5 class="text-xl-center">
         <i class="fa-fw fas fa-prescription-bottle-alt text-primary"></i> <a class="text-dark" href="{{route('eac.portal.drug.list')}}">Drugs</a>
        </h5>
        <p class="text-muted mb-0 small text-xl-center">
         Manage the Investigative drugs your company offers
        </p>
       </div>
       <div class="d-flex">
        <div class="p-3 h4 mb-0 alert-primary">
         <a href="{{route('eac.portal.drug.list')}}" class="text-nowrap text-primary">{{$drugs->count()}}</a>
        </div>
        <a href="{{ route('eac.portal.drug.create') }}" class="btn btn-primary btn-block btn-lg d-flex justify-content-between align-items-center">
         Submit Drug <i class="fa-fw fas fa-prescription-bottle-alt"></i>
        </a>
       </div>
      </div>
     @endif
    </div>
    <div class="col-sm-4 mb-3 mb-xl-5">
     <div class="card">
      <div class="card-body">
       <h5 class="text-xl-center">
        <i class="fa-fw fas fa-bell text-success"></i> <a href="#" class="text-dark toggleRight">Notifications</a>
       </h5>
       <p class="text-muted mb-0 small text-xl-center">
        View your notifications within the Early Access Care&trade; platform
       </p>
      </div>
      <div class="d-flex">
       <div class="p-3 h4 mb-0 alert-success text-success">
        <a href="#" class="text-nowrap text-success toggleRight">{{\Auth::user()->notifications()->count()}}</a>
       </div>
       <a href="#" class="toggleRight btn btn-success btn-block btn-lg d-flex justify-content-between align-items-center">
        Notifications <i class="fa-fw fas fa-bell"></i>
       </a>
      </div>
     </div>
    </div>
    <div class="col-sm-4 mb-3 mb-xl-5">
     <div class="card">
      <div class="card-body">
       <h5 class="text-xl-center">
        <i class="fa-fw fas fa-user-md text-dark"></i> <a class="text-dark" href="{{ route('eac.portal.user.show', \Auth::user()->id) }}">Account Settings</a>
       </h5>
       <p class="text-muted mb-0 small text-xl-center">
        Manage your user information and company address
       </p>
      </div>
      <a href="{{ route('eac.portal.user.show', \Auth::user()->id) }}" class="btn btn-dark btn-block btn-lg d-flex justify-content-between align-items-center">
       My Account <i class="fa-fw fas fa-user-md"></i>
      </a>
     </div>
    </div>
   </div>
   <div class="viewData">
    <div class="card mb-1 mb-md-4">
     <div class="table-responsive">
      <table class="table table-sm table-striped table-hover" id="companyDrugListTBL">
       <thead>
       <tr>
        <th>Drug Name</th>
        <th>Status</th>
        <th>Submitted Date</th>
        <th></th>
       </tr>
       </thead>
       <tbody></tbody>
      </table>
     </div>
    </div>
   </div>
  @endif

  <div class="actionBar">
   <a href="{{ route('eac.portal.company.create') }}" class="btn btn-success d-none">
    <i class="fa-fw fas fa-building"></i> Add Company
   </a>
   @if(\Auth::user()->hasDefaultPassword())
    <a href="{{ route('eac.portal.user.create') }}" class="btn btn-primary">
     <i class="fa-fw fas fa-lock"></i> Set Your Password
    </a>
   @endif
  </div><!-- end .actionBar -->

@endsection
@section('scripts')
	<script>
		//Rid Shipment Table
		$(document).ready(function () {
			/**
			 * ridShipFormat
			 * @param {object} $d - original data object for the row
			 * @returns {string} newly formatted row
			 */
			function ridShipFormat($d) {
				return '<table>' +
					'<tr>' +
					'<td>Delivery By Date:</td>' +
					'<td>' + $d.delivery_by_date + '</td>' +
					'</tr>' +
					'<tr>' +
					'<td>Destination:</td>' +
					'<td>' + $d.destination + '</td>' +
					'</tr>' +
					'</table>';
			}

			var dataTable5 = $('#ridAwaitingListTBL').DataTable({
				columnDefs: [{
					targets: 'no-sort',
					orderable: false,
				}],
				"paginationDefault": 10,
				"paginationOptions": [10, 25, 50, 75, 100],
				// "responsive": true,
				'order': [[3, 'asc']],
				"ajax": {
					url: "{{route('eac.portal.rid.ajax.ridawaitinglist')}}",
					type: "post"
				},
				"columns": [
					{
						"className": 'details-control',
						"orderable": false,
						"data": null,
						"defaultContent": '<i class="fas fa-plus"></i>'
					},
					{"data": "number"},
					{"data": "drug"},
					{"data": "ship_by_date"},
					{"data": "btns"},

				]
			});
			dataTable5.columns().every(function () {
				var that = this;
				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that
							.search(this.value)
							.draw();
					}
				});
			});
			dataTable5.columns().every(function () {
				var that = this;
				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that.search(this.value).draw();
					}
				});
			});
			$('#ridAwaitingListTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search")) {
					$(this).text("");
				} else {
					$(this).html('<input type="text" class="form-control" placeholder="Search ' + $(this).text() + '"/>');
				}
			});
			$('#ridAwaitingListTBL tbody').on('click', 'td.details-control', function () {
				var tr = $(this).closest('tr');
				var row = dataTable5.row(tr);

				if (row.child.isShown()) {
					// This row is already open - close it
					row.child.hide();
					tr.removeClass('shown');
				} else {
					// Open this row
					row.child(ridShipFormat(row.data())).show();
					tr.addClass('shown');
				}
			});
		});

		// Recent Activity List
		$(document).ready(function () {
			$('#recentActivityList tfoot th').each(function () {
				if ($(this).hasClass("no-search")) {
					$(this).text("");
					return;
				}
				var title2 = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title2 + '"/>');
			});
			var dataTable6 = $('#recentActivityList').DataTable({

				fnDrawCallback: function () {
					jQuery("input[data-toggle='toggle']").bootstrapToggle();
				},
				"paginationDefault": 10,
				"paginationOptions": [10, 25, 50, 75, 100],
				"responsive": false,
				"searching": false,
				'order': [[0, 'desc']],
				"ajax": {
					url: "{{route('eac.portal.dashboard.ajax.ajaxrecentactivity')}}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{"data": "date", "name": "date"},
					{"data": "item", "name": "item"},
					{"data": "status", "name": "status"},
					{"data": "type", "name": "type"},
					{"data": "activity", "name": "activity"},
					{"data": "ops_btns"}
				]
			});
		});
	</script>


	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endsection