@extends('layouts.portal')

@section('title')
 View Company
@endsection

@section('styles')
 <style>
  .hide-tab {
   display: none;
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
   {{ $company->name }}
   <small>({{ $company->abbr }})</small>
  </h2>
  <div class="small d-sm-none">
   <strong>Last Updated:</strong>
   @php
    $time = $company->updated_at;
    
    echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
   @endphp
  </div>
 </div><!-- end .titleBar -->
 <div class="viewData">
  <div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
   <a href="{{ route("eac.portal.company.list") }}" class="btn btn-light">
    Companies List
   </a>
   <div>
    <a href="{{ route("eac.portal.company.edit", $company->id) }}" class="btn btn-info">
     <i class="far fa-edit"></i>
     Edit Company
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
       <strong class="text-warning">{{-- {{$company->rids->count()}} --}}</strong>
       Requests
      </a>
     @endif
    </div>
   </div>
   <div class="col-sm-9 col-lg-7 col-xl p-0">
    <div class="card tab-content wizardContent" id="tabContent">
     <div class="alert-light text-dark pt-3 pl-3 pr-3">
      <div class="row">
       <div class="col col-xl-auto mb-3">
        <strong>{{$company->name}}</strong>
        ({{$company->abbr}})
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
           <a target="_blank" href="mailto:{{$company->email_main}}" class="small" data-toggle="tooltip" data-placement="bottom" title="Email {{$company->email_main}}">
            <i class="text-secondary fa-fw fas fa-envelope fa-sm"></i>
           </a>
          </li>
         @endif
        </ul>
       </div>
       <div class="order-3 order-md-2 col-md col-xl-auto ml-xl-auto mr-xl-auto mb-3">
        @if(isset($company->address))
         <div class="small">
          {{ $company->address->addr1 }}{{$company->address->addr2 ? ', ' . $company->address->addr2 : "" }}
          <br/>
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
         <i class="fal fa-info-circle"></i>
         No information available
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
                   <span class="d-none d-lg-inline">{{$department->phone->number}}</span>
                   <span class="d-lg-none">Phone</span>
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
                  <a target="_blank" href="mailto:{{$department->email}}" class="btn btn-link btn-sm p-0" title="{{$department->email}}">
                   <span class="d-none d-lg-inline">{{$department->email}}</span>
                   <span class="d-lg-none">Email</span>
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
         <i class="fal fa-info-circle"></i>
         No information available
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
         <table class="table table-hover table-sm resourcesDT" id="companyDrugListTBL">
          <thead>
          <tr>
           <th>Drug Name</th>
           <th>Status</th>
           <th>Created At</th>
          </tr>
          </thead>
          <tbody>
          @foreach($company->drugs->sortBy('name') as $drug)
           <tr>
            <td>
             <a href="{{$drug->view_route}}">
              {{$drug->name}}
             </a>
            </td>
            <td>
             {{$drug->status}}
            </td>
            <td>
             {{$drug->created_at->format(config('eac.date_format'))}}
            </td>
           </tr>
          @endforeach
          </tbody>
         </table>
        </div>
       @else
        <p class="text-muted m-0">
         <i class="fal fa-info-circle"></i>
         No information available
        </p>
       @endif
      </div>
     </div><!-- /.tab-pane -->
     <div class="tab-pane fade" id="xusers" role="tabpanel" aria-labelledby="xusers-tab">
      <div class="card-body">
       <h5 class="mb-3">
        <strong>Assigned Users</strong>
        @if($company->users->count() > 0)
         <span class="badge badge-dark">{{$company->users->count()}}</span>
        @endif
       </h5>
       @if($company->users->count() > 0)
        <div class="table-responsive">
         <table class="table table-hover table-sm resourcesDT" id="assignUSERsListTBL">
          <thead>
          <tr>
           <th>Name</th>
           <th>Email</th>
           <th>Created At</th>
          </tr>
          </thead>
          <tbody>
          @foreach($company->users->sortBy('full_name') as $user)
           <tr>
            <td>
             <a href="{{ route('eac.portal.user.show', $user->id) }}">
              {{$user->full_name}}
             </a>
            </td>
            <td>
             {{$user->email}}
            </td>
            <td>
             {{$user->created_at->format(config('eac.date_format'))}}
            </td>
           </tr>
          @endforeach
          </tbody>
         </table>
        </div>
       @else
        <p class="text-muted m-0">
         <i class="fal fa-info-circle"></i>
         No assigned users available
        </p>
       @endif
      </div>
     </div><!-- /.tab-pane -->
     @if($company->rids->count() > 0)
      <div class="tab-pane fade  " id="xrequests" role="tabpanel" aria-labelledby="xrequests-tab">
       <div class="card-body">
        <h5 class="mb-3">
         <strong>RIDs</strong>
         @if($company->rids->count() > 0)
          <span class="badge badge-dark">{{$company->rids->count()}}</span>
         @endif
        </h5>
        <div class="table-responsive">
         <table class="table table-hover table-sm resourcesDT" id="assocRidListTBL">
          <thead>
          <tr>
           <th>RID Number</th>
           <th>RID Status</th>
           <th>Drug Requested</th>
           <th>Created At</th>
          </tr>
          </thead>
          <tbody>
          @foreach($company->rids->sortByDesc('created_at') as $rid)
           <tr>
            <td>
             <a href="{{$rid->view_route}}">
              {{$rid->number}}
             </a>
            </td>
            <td>
             {{$rid->status->name}}
            </td>
            <td>
             <a href="{{$rid->drug->view_route}}">
              {{$rid->drug->name}}
             </a>
            </td>
            <td>
             {{$rid->created_at->format(config('eac.date_format'))}}
            </td>
           </tr>
          @endforeach
          </tbody>
         </table>
        </div>
       </div>
      </div><!-- /.tab-pane -->
     @endif
    </div>
   </div>
  </div>
 </div><!-- end .viewData -->

@endsection

@section('scripts')
@endsection
