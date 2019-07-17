@extends('layouts.portal')

@section('title')
	View Company
@endsection

@section('styles')
 <style>
  .hide-tab{
      display:none;
    }
  @media screen and (min-width: 1200px) {
   :root {
    --leftCol: 230px;
    --rightCol: 750px;
   }
   .actionBar, .viewData {
    max-width: calc(var(--leftCol) + var(--rightCol));
   }
   .viewData .row.thisone > [class*=col]:first-child {
    max-width: var(--leftCol);
    min-width: var(--leftCol);
   }
   .viewData .row.thisone > [class*=col]:last-child {
    max-width: var(--rightCol);
    min-width: var(--rightCol);
   }
  }
 </style>
@endsection

@php
 $bColor = '';
 if($company->status == 'Approved') {
  $bColor = 'success';
 } // endif
 if($company->status == 'Not Approved') {
  $bColor = 'danger';
 } // endif
 if($company->status == 'Pending') {
  $bColor = 'warning';
 } // endif
@endphp

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <div class="row">
    <div class="col-sm-auto">
     <ol class="breadcrumb">
      <li class="breadcrumb-item">
       <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
       <a href="{{ route('eac.portal.company.list') }}">All Companies</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
       {{ $company->name }}
      </li>
     </ol>
    </div>
    <div class="d-none d-sm-block col-sm-auto ml-sm-auto">
     <div class="small">
      <strong>Last Updated:</strong>
      @php
       $time = $company->updated_at;
       $time->tz = "America/New_York";
       echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
      @endphp
     </div>
    </div>
   </div>
  </nav>
  <h6 class="title small upper m-0">
   @yield('title')
  </h6>
  <h2 class="m-0">
   {{ $company->name }} <small>({{ $company->abbr }})</small>
  </h2>
  <div class="small d-sm-none">
   <strong>Last Updated:</strong>
   @php
    $time = $company->updated_at;
    $time->tz = "America/New_York";
    echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
   @endphp
  </div>
 </div><!-- end .titleBar -->
 <div class="viewData">
  <div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
   <a href="{{ route("eac.portal.company.list") }}" class="btn btn-light">
    <i class="fa-fw fas fa-arrow-left"></i> Return to Companies List
   </a>
   <div>
    <a href="{{ route("eac.portal.company.edit", $company->id) }}" class="btn btn-info">
     <i class="far fa-edit"></i> Edit Company
    </a>
   </div>
  </div>
  <div class="row thisone m-0 mb-xl-5">
   <div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
    <div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist" aria-orientation="vertical">
     {{-- <a class="nav-link complete" id="xdetails-tab" data-toggle="pill" href="#xdetails" role="tab" aria-controls="xdetails" aria-selected="true">
      <span>Company Details</span>
     </a> --}}
     <a class="nav-link active @if($company->desc) complete @else hide-tab @endif" id="xwebdesc-tab" data-toggle="pill" href="#xwebdesc" role="tab" aria-controls="xwebdesc" aria-selected="true">
      <span>Website Description</span>
     </a>
     <a class="nav-link @if($company->departments->count() > 0) complete @else hide-tab @endif" id="xcontacts-tab" data-toggle="pill" href="#xcontacts" role="tab" aria-controls="xcontacts" aria-selected="false">
      <span>Departments</span>
     </a>
     <a class="nav-link @if($company->users->count() > 0) complete @else hide-tab @endif" id="xusers-tab" data-toggle="pill" href="#xusers" role="tab" aria-controls="xusers" aria-selected="false">
      <span>Assigned Users</span>
     </a>
     <a class="nav-link @if($company->drugs->count() > 0) complete @else hide-tab @endif" id="xdrugs-tab" data-toggle="pill" href="#xdrugs" role="tab" aria-controls="xdrugs" aria-selected="false">
      <span>Submitted Drugs</span>
     </a>
     @if($company->rids->count() > 0)
      <a class="nav-link complete" id="xrequests-tab" data-toggle="pill" href="#xrequests" role="tab" aria-controls="xrequests" aria-selected="false">
       <strong class="text-warning">{{-- {{$company->rids->count()}} --}}</strong> Requests
      </a>
     @endif
    </div>
   </div>
   <div class="col-sm-9 col-lg-7 col-xl p-0">
    <div class="card tab-content wizardContent" id="tabContent">
     <div class="alert-light text-dark pt-3 pl-3 pr-3">
      <div class="row">
       <div class="col col-xl-auto mb-3">
        <strong>{{$company->name}}</strong> ({{$company->abbr}})
        <span class="badge badge-{{$bColor}}">{{ $company->status }}</span>
        <ul class="nav flex-row m-0">
         @if($company->site)
          <li class="nav-item">
           <a href="http://{{$company->site}}" target="_blank" class="small" data-toggle="tooltip" data-placement="bottom" title="View Website: {{$company->site}}">
            <i class="text-secondary fa-fw fas fa-external-link-alt fa-sm"></i>
           </a>
          </li>
          <li class="nav-item pl-2 pr-2 d-none d-sm-block text-secondary">|</li>
         @endif
         @if($company->phone_main)
          <li class="nav-item">
           <a href="tel:{{$company->phone->number}}" class="small" data-toggle="tooltip" data-placement="bottom" title="Call {{$company->phone->number}}">
            <i class="text-secondary fa-fw fas fa-phone fa-rotate-90 fa-sm"></i>
           </a>
          </li>
         @endif
         @if(($company->phone_main) && ($company->email_main))
          <li class="nav-item pl-2 pr-2 d-none d-sm-block text-secondary">|</li>
         @endif
         @if($company->email_main)
          <li class="nav-item">
           <a href="mailto:{{$company->email_main}}" class="small" data-toggle="tooltip" data-placement="bottom" title="Email {{$company->email_main}}">
            <i class="text-secondary fa-fw fas fa-envelope fa-sm"></i>
           </a>
          </li>
         @endif
        </ul>
       </div>
       <div class="order-3 order-md-2 col-md col-xl-auto ml-xl-auto mr-xl-auto mb-3">
        @if(isset($company->address))
         <div class="small"> 
          {{ $company->address->addr1 }}{{$company->address->addr2 ? ', ' . $company->address->addr2 : "" }}<br/>
          {{ $company->address->city }}, 
          @if($company->address->state){{  $company->address->state->abbr }}@endif {{ $company->address->zipcode }}, {{ $company->address->country->name }}
         </div>
        @endif
       </div>
       <div class="order-2 order-md-3 col-auto mb-3">
        <small class="upper d-block">Created On</small>
        <strong>{{date('Y-m-d', strtotime($company->created_at))}}</strong>
       </div>
      </div>
     </div>
{{--      <div class="tab-pane fade" id="xdetails" role="tabpanel" aria-labelledby="xdetails-tab">
      <div class="card-body">
       <div class="row">
        <div class="col col-sm-7 col-md-9 col-xl-7 mb-3 mb-xl-2">
         <div class="mb-3 mb-xl-2">
          <strong>{{$company->name}}</strong> ({{$company->abbr}})
         </div>
         @if(($company->phone_main) || ($company->email_main))
          <ul class="nav flex-column flex-md-row m-0">
           @if($company->site)
            <li class="nav-item">
             <a href="http://{{$company->site}}" target="_blank" class="btn btn-link p-0" data-toggle="tooltip" data-placement="bottom" title="View Website: {{$company->site}}">
              <i class="text-secondary fa-fw fas fa-external-link-alt"></i> View Website
             </a>
            </li>
            <li class="nav-item pl-2 pr-2 d-none d-md-block">|</li>
           @endif
           @if($company->phone_main)
            <li class="nav-item">
             <a href="tel:{{$company->phone->number}}" class="btn btn-link p-0" data-toggle="tooltip" data-placement="bottom" title="Call {{$company->phone->number}}">
              <i class="text-secondary fa-fw fas fa-phone fa-rotate-90"></i> Phone
             </a>
            </li>
           @endif
           @if(($company->phone_main) && ($company->email_main))
            <li class="nav-item pl-2 pr-2 d-none d-md-block">|</li>
           @endif
           @if($company->email_main)
            <li class="nav-item">
             <a href="mailto:{{$company->email_main}}" class="btn btn-link p-0" data-toggle="tooltip" data-placement="bottom" title="Email {{$company->email_main}}">
              <i class="text-secondary fa-fw fas fa-envelope"></i> Email
             </a>
            </li>
           @endif
          </ul>
         @endif
        </div>
        <div class="col-auto col-sm-5 col-md-3 col-xl-5 mb-3 mb-xl-2">
         <span class="badge badge-{{$bColor}}">{{ $company->status }}</span>
        </div>
        <div class="col-sm-7 col-md-9 col-xl-7">
         @if(isset($company->address))
          <div class="mb-2"> 
           {{ $company->address->addr1 }}{{$company->address->addr2 ? ', ' . $company->address->addr2 : "" }}<br/>
           {{ $company->address->city }}, 
           @if($company->address->state){{  $company->address->state->abbr }}@endif {{ $company->address->zipcode }}
           <br/>
           {{ $company->address->country->name }}
          </div>
         @endif
        </div>
        <div class="col-sm-5 col-md-3 col-xl-5">
         <label class="text-muted d-block">Added</label>
         {{date('Y-m-d', strtotime($company->created_at))}}
        </div>
       </div>
      </div>
     </div><!-- /.tab-pane --> --}}
     <div class="tab-pane fade show active" id="xwebdesc" role="tabpanel" aria-labelledby="xwebdesc-tab">
      <div class="card-body">
       <h5 class="mb-3">
        <strong>Website Description</strong>
       </h5>
       @if($company->desc)
        <div class="pre-scrollable">
         {!!$company->desc!!}
        </div>
       @else
        <p class="text-muted m-0">
         <i class="fal fa-info-circle"></i> No information available
        </p>
       @endif
      </div>
     </div><!-- /.tab-pane -->
     <div class="tab-pane fade" id="xcontacts" role="tabpanel" aria-labelledby="xcontacts-tab">
      <div class="card-body">
       <h5 class="mb-3">
        <strong>Departments</strong>
        @if($company->departments->count() > 0)
         <span class="badge badge-dark">
          {{$company->departments->count()}}
         </span>
        @endif
       </h5>
       @if($company->departments->count() > 0)
        <div class="row">
         {{-- 
         <div class="col-auto col-sm-6 mb-3">
          <div class="p-3 mb-0 h-100" style="border: 1px dotted #ececec">
           <h6 class="upper">
            Main
           </h6>
           @if(($company->phone_main) || ($company->email_main))
            <ul class="nav flex-column flex-md-row m-0">
             @if($company->phone_main)
              <li class="nav-item">
               <a href="tel:{{$company->phone->number}}" class="btn btn-link p-0" data-toggle="tooltip" data-placement="bottom" title="Call {{$company->phone->number}}">
                <i class="text-secondary fa-fw fas fa-phone fa-rotate-90"></i> Phone
               </a>
              </li>
             @endif
             @if(($company->phone_main) && ($company->email_main))
              <li class="nav-item pl-2 pr-2 d-none d-md-block">|</li>
             @endif
             @if($company->email_main)
              <li class="nav-item">
               <a href="mailto:{{$company->email_main}}" class="btn btn-link p-0" data-toggle="tooltip" data-placement="bottom" title="Email {{$company->email_main}}">
                <i class="text-secondary fa-fw fas fa-envelope"></i> Email
               </a>
              </li>
             @endif
            </ul>
           @else
            <p class="card-text mb-0">
             <span class="text-muted">Not Available</span>
            </p>
           @endif
          </div><!-- /.card -->
         </div>
         --}}
         @foreach($company->departments as $department)
          <div class="col-sm-6 mb-3">
           <div class="card h-100 border-light bs-no border">
            <div class="card-body p-3">
             <h6 class="mb-2 strong">
              {{$department->name}}
             </h6>
             <div class="row">
              @if($department->phone_id)
               <div class="col-auto col-md-12">
                <div class="row m-0 small mb-1 align-items-center">
                 <div class="col-auto p-0">
                  <i class="text-secondary fa-fw fas fa-phone fa-rotate-90"></i>
                 </div>
                 <div class="col pl-2 pr-0 wraphelp">
                  <a href="tel:{{$department->phone->number}}" class="btn btn-link btn-sm p-0" title="{{$department->phone->number}}">
                   <span class="d-none d-lg-inline">{{$department->phone->number}}</span> <span class="d-lg-none">Phone</span>
                  </a>
                 </div>
                </div><!-- /.row -->
               </div>
              @endif
              @if($department->email)
               <div class="col-auto col-md-12">
                <div class="row m-0 small mb-1 align-items-center">
                 <div class="col-auto p-0">
                  <i class="text-secondary fa-fw fas fa-envelope"></i>
                 </div>
                 <div class="col pl-2 pr-0 wraphelp">
                  <a href="mailto:{{$department->email}}" class="btn btn-link btn-sm p-0" title="{{$department->email}}">
                   <span class="d-none d-lg-inline">{{$department->email}}</span> <span class="d-lg-none">Email</span>
                  </a>
                 </div>
                </div><!-- /.row -->
               </div>
              @endif
             </div>
            </div>
           </div>
          </div>
         @endforeach
        </div><!-- /.row -->
       @else
        <p class="text-muted m-0">
         <i class="fal fa-info-circle"></i> No information available
        </p>
       @endif
      </div>
     </div><!-- /.tab-pane -->
     <div class="tab-pane fade" id="xdrugs" role="tabpanel" aria-labelledby="xdrugs-tab">
      <div class="card-body">
       <h5 class="mb-3">
        <strong>Submitted Drugs</strong>
        @if($company->drugs->count() > 0)
         <span class="badge badge-dark">{{ $company->drugs->count() }}</span>
        @endif
       </h5>
       @if($company->drugs->count() > 0)
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
          <tfoot>
          <tr>
           <th>Drug Name</th>
           <th class="no-search">Status</th>
           <th>Submitted Date</th>
           <th class="no-search"></th>
          </tr>
          </tfoot>
         </table>
        </div>
       @else
        <p class="text-muted m-0">
         <i class="fal fa-info-circle"></i> No information available
        </p>
       @endif
      </div>
     </div><!-- /.tab-pane -->
     <div class="tab-pane fade  " id="xusers" role="tabpanel" aria-labelledby="xusers-tab">
      <div class="card-body">
       <h5 class="mb-3">
        <strong>Assigned Users</strong>
        @if($company->users->count() > 0)
         <span class="badge badge-dark">{{$company->users->count()}}</span>
        @endif
       </h5>
       @if($company->users->count() > 0)
        <div class="table-responsive">
         <table class="table cusGem table-sm table-striped table-hover">
          <thead>
           <tr>
            <th>Name</th>
            <th>Email</th>
            <th></th>
           </tr>
          </thead>
          <tbody>
           @foreach(App\User::all() as $user)
            @if($user->company_id == $company->id)
            <tr>
             <td>
              <a href="{{ route('eac.portal.user.show', $user->id) }}">
               {{$user->full_name}}
              </a>
             </td>
             <td>
              {{$user->email}}
             </td>
             <td class="text-right">
              @if($user->company_id == $company->id)
               <a href="{{ route('eac.portal.company.user.remove', [$company->id, $user->id]) }}" class="text-danger" title="Remove User">
                <i class="fal fa-times"></i> <span class="sr-only">Unassign</span>
               </a>
              @endif
             </td>
            </tr>
            @endif
           @endforeach
          </tbody>
         </table>
        </div>
       @else
        <p class="text-muted m-0">
         <i class="fal fa-info-circle"></i> No assigned users available
        </p>
       @endif
      </div>
     </div><!-- /.tab-pane -->
     @if($company->rids->count() > 0)
      <div class="tab-pane fade  " id="xrequests" role="tabpanel" aria-labelledby="xrequests-tab">
       <div class="card-body">
        <div class="table-responsive">
         <table class="table table-hover table-sm" id="assocRidListTBL">
          <thead>
          <tr>
           <th>RID Number</th>
           <th>RID Status</th>
           <th>Drug Requested</th>
           <th>Request Date</th>
           <th></th>
          </tr>
          </thead>
          <tbody></tbody>
          {{-- <tfoot>
          <tr>
           <th>RID Number</th>
           <th class="no-search">RID Status</th>
           <th>Drug Requested</th>
           <th>Request Date</th>
           <th class="no-search"></th>
          </tr>
          </tfoot> --}}
         </table>
        </div>
       </div>
      </div><!-- /.tab-pane -->
     @endif
    </div>
   </div>
  </div>
  {{-- new design concept <end> here  --}}

    {{-- <div class="row">
   <div class="col-xl-4">
    <div class="tabs2o">
     <ul class="nav nav-tabs" id="Deets2" role="tablist">
      <li class="nav-item">
       <a class="nav-link active" id="fow-tab" data-toggle="tab" href="#fow" role="tab" aria-controls="fow" aria-selected="true">
        Details
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link" id="deem-tab" data-toggle="tab" href="#deem" role="tab" aria-controls="deem" aria-selected="false">
        Company Contacts
       </a>
      </li>
     </ul>
     <div class="card card-body tab-content mb-3 mb-xl-5" id="Deets2Content">
      <div class="tab-pane fade show active" id="fow" role="tabpanel" aria-labelledby="fow-tab">
       <div class="mb-2">
        <label class="d-block">Company Name</label>
        {{ $company->name }}
       </div>
       <div class="mb-2">
        <label class="d-block">Abbreviation</label>
        {{ $company->abbr }}
       </div>
       <div class="mb-2">
        <label class="d-block">Status</label>
        {{ $company->status }}
       </div>
       <div class="mb-2">
        <label class="d-block">Address</label>
        @if(isset($company->address))
         {{ $company->address->addr1 }} <br/>
         @if(isset($company->address->addr2))
          {{ $company->address->addr2 }} <br/>
         @endif
         {{ $company->address->city }}
         , @if($company->address->state){{  $company->address->state->abbr }}@endif {{ $company->address->zipcode }}
         <br/>
         {{ $company->address->country->name }}
        @else
         No Address data.
        @endif
       </div>
       <div class="mb-2">
        <label class="d-block">Company Website</label>
        @if($company->site)
         <a href="http://{{$company->site}}" target="_blank">{{$company->site}}</a>
        @else
         <small class="text-muted">N/A</small>
        @endif
       </div>
      </div>
      <div class="tab-pane fade" id="deem" role="tabpanel" aria-labelledby="deem-tab">
       <ul class="list-group list-group-flush">
        <li class="list-group-item list-group-item-light pt-1 pb-1">
         <label>Main</label>
        </li>
        <li class="list-group-item">
         <div>
          <i class="fas fa-phone"></i> <span class="sr-only">Main Phone</span> 
          @if($company->phone_main)
           <a href="tel:{{$company->phone->number}}">{{$company->phone->number}}</a>
          @else
           <small class="text-muted">N/A</small>
          @endif
         </div>
         <div>
          <i class="fas fa-at"></i> <span class="sr-only">Main Email</span> 
          @if($company->email_main)
           <a href="mailto:{{$company->email_main}}">{{$company->email_main}}</a>
          @else
           <small class="text-muted">N/A</small>
          @endif
         </div>
        </li>
        @foreach($company->departments as $department)
         <li class="list-group-item list-group-item-light pt-1 pb-1">
          <label>{{$department->name}}</label>
         </li>
         <li class="list-group-item">
          @if($department->phone_id)
           <div>
            <i class="fas fa-phone"></i> <span class="sr-only">Phone</span>
            <a href="tel:{{$department->phone->number}}">{{$department->phone->number}}</a>
           </div>
          @endif
          @if($department->email)
           <div>
            <i class="fas fa-phone"></i> <span class="sr-only">Email</span>
            <a href="mailto:{{$department->email}}">{{$department->email}}</a>
           </div>
          @endif
         </li>
        @endforeach
       </ul>

      </div>
     </div>
    </div>
   </div>
   <div class="col-xl-8">
    <div class="tabs2o">
     <ul class="nav nav-tabs" id="Deets2" role="tablist">
      <li class="nav-item">
       <a class="nav-link active" id="won-tab" data-toggle="tab" href="#won" role="tab" aria-controls="won" aria-selected="true">
        Submitted Drugs
        <span class="badge badge-dark">{{ $company->drugs->count() }}</span>
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link" id="too-tab" data-toggle="tab" href="#too" role="tab" aria-controls="too" aria-selected="false">
        Assigned Users
        <span class="badge badge-dark">{{ $company->users->count() }}</span>
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link" id="tree-tab" data-toggle="tab" href="#tree" role="tab" aria-controls="tree" aria-selected="false">
        Requests
        <span class="badge badge-dark">{{ $company->rids->count() }}</span>
       </a>
      </li>
     </ul>
     <div class="card card-body tab-content mb-3 mb-xl-5 p-2" id="Deets2Content">
      <div class="tab-pane fade show active" id="won" role="tabpanel" aria-labelledby="won-tab">
       <div class="table-responsive">
        <table class="table table-hover table-sm" id="companyDrugListTBL">
         <thead>
         <tr>
          <th>Drug Name</th>
          <th>Status</th>
          <th>Submitted Date</th>
          <th></th>
         </tr>
         </thead>
         <tbody></tbody>
         <tfoot>
         <tr>
          <th>Drug Name</th>
          <th class="no-search">Status</th>
          <th>Submitted Date</th>
          <th class="no-search"></th>
         </tr>
         </tfoot>
        </table>
       </div>
      </div>
      <div class="tab-pane fade" id="too" role="tabpanel" aria-labelledby="too-tab">
       <div class="table-responsive">
        <table class="table table-hover table-sm" id="companyUserListTBL">
         <thead>
         <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Status</th>
          <th></th>
         </tr>
         </thead>
         <tbody></tbody>
         <tfoot>
         <tr>
          <th>Name</th>
          <th>Email</th>
          <th class="no-search">Status</th>
          <th class="no-search"></th>
         </tr>
         </tfoot>
        </table>
       </div>
      </div>
      <div class="tab-pane fade" id="tree" role="tabpanel" aria-labelledby="tree-tab">
       <div class="table-responsive">
        <table class="table table-hover table-sm" id="assocRidListTBL">
         <thead>
         <tr>
          <th>RID Number</th>
          <th>RID Status</th>
          <th>Drug Requested</th>
          <th>Request Date</th>
          <th></th>
         </tr>
         </thead>
         <tbody>
				 </tbody>
         <tfoot>
         <tr>
          <th>RID Number</th>
          <th class="no-search">RID Status</th>
          <th>Drug Requested</th>
          <th>Request Date</th>
          <th class="no-search"></th>
         </tr>
         </tfoot>
        </table>
       </div>
      </div>
     </div>
    </div> 

   </div>
  </div>--}}
	</div><!-- end .viewData -->

@endsection

@section('scripts')

	<script type="text/javascript">
		// Data Tables
		$(document).ready(function () {
			$('#companyDrugListTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search")) {
					$(this).text("");
					return;
				}
				var title = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
			});

			var dataTable = $('#companyDrugListTBL').DataTable({
				"paginationDefault": 10,
        "paginationOptions": [10, 25, 50, 75, 100],
				// "responsive": true,
				"ajax": {
					url: "{{ route('eac.portal.company.ajax.drug.list', $company->id) }}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{"data": "name", 'name': 'name'},
					{"data": "status"},
					{"data": "created_at"},
					{"data": "ops_btns", orderable: false},
				]
			});

			dataTable.columns().every(function () {
				var that = this;

				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that
							.search(this.value)
							.draw();
					}
				});
			});

			dataTable.columns().every(function () {
				var that = this;
				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that.search(this.value).draw();
					}
				});
			});

			$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
				swal({
					title: "Oh Snap!",
					text: "Something went wrong on our side. Please try again later.",
					icon: "warning",
				});
			};

		}); // end doc ready
	</script>

	<script type="text/javascript">
		// Data Tables
		$(document).ready(function () {
			// $('#assocRidListTBL tfoot th').each(function () {
			// 	if ($(this).hasClass("no-search")) {
			// 		$(this).text("");
			// 		return;
			// 	}
			// 	var title = $(this).text();
			// 	$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
			// });

			var dataTable = $('#assocRidListTBL').DataTable({
				"paginationDefault": 10,
        "paginationOptions": [10, 25, 50, 75, 100],
				// "responsive": true,
				"ajax": {
					url: "{{ route('eac.portal.company.ajax.rid.list', $company->id) }}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{"data": "number", "name": "number"},
					{"data": "status"},
					{"data": "drug_name", 'name': 'drug_name', orderable: true},
					{"data": "created_at", 'name': 'created_at'},
					{"data": "ops_btns", orderable: false},
				]
			});

			dataTable.columns().every(function () {
				var that = this;

				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that
							.search(this.value)
							.draw();
					}
				});
			});

			dataTable.columns().every(function () {
				var that = this;
				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that.search(this.value).draw();
					}
				});
			});

			$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
				swal({
					title: "Oh Snap!",
					text: "Something went wrong on our side. Please try again later.",
					icon: "warning",
				});
			};

		}); // end doc ready
	</script>

	<script type="text/javascript">
		$(document).ready(function () {
			$('#companyUserListTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search")) {
					$(this).text("");
					return;
				}
				var title = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
			});

			var dataTable = $('#companyUserListTBL').DataTable({
				"paginationDefault": 10,
        "paginationOptions": [10, 25, 50, 75, 100],
        "order":[[0,'asc']],
				// "responsive": true,
				"ajax": {
					url: "{{ route('eac.portal.company.ajax.userList', $company->id) }}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{"data": "name", "name": "name"},
					{"data": "email"},
					{"data": "status", orderable: false},
					{"data": "ops_btns", orderable: false},
				]
			});

			dataTable.columns().every(function () {
				var that = this;

				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that
							.search(this.value)
							.draw();
					}
				});
			});

			dataTable.columns().every(function () {
				var that = this;
				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that.search(this.value).draw();
					}
				});
			});

			$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
				swal({
					title: "Oh Snap!",
					text: "Something went wrong on our side. Please try again later.",
					icon: "warning",
				});
			};

		}); // end doc ready
	</script>

@endsection
