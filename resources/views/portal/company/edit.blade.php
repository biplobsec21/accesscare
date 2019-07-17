@extends('layouts.portal')

@section('title')
 Edit Company
@endsection

@section('styles')
 <style>
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
      <li class="breadcrumb-item">
       <a href="{{ route('eac.portal.company.show', $company->id) }}">{{ $company->name }}</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
       @yield('title')
      </li>
     </ol>
    </div>
    <div class="d-none d-sm-block col-sm-auto ml-sm-auto">
     <div class="small">
      @if(!is_null($company->updated_at))
       <strong>Last Updated:</strong>
       @php
        $time = $company->updated_at;
        $time->tz = "America/New_York";
        echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
       @endphp
      @endif
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
   @if(!is_null($company->updated_at))
    <strong>Last Updated:</strong>
    @php
     $time = $company->updated_at;
     $time->tz = "America/New_York";
     echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
    @endphp
   @endif
  </div>
 </div><!-- end .titleBar -->

 <div class="viewData">
  <form name="" method="POST" action="{{ route('eac.portal.company.update') }}">
   {{ csrf_field() }}
   @php
    if(Session::has('alerts')) {
     $alert = Session::get('alerts');
     $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
     echo $alert_dismiss;
    }
   @endphp
   <div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
    <a href="{{ route('eac.portal.company.show', $company->id) }}" class="btn btn-secondary">
     <i class="fal fa-angle-double-left"></i> Return to View Company
    </a>
    <div>
     @if($company->status == 'Approved')
      <a href="{{ route('eac.portal.company.suspend', $company->id) }}" class="btn btn-danger">
       <i class="fal fa-ban"></i> Suspend Company
      </a>
     @elseif($company->status == 'Pending')
      <a href="{{ route('eac.portal.company.approve', $company->id) }}" class="btn btn-success">
       <i class="fal fa-check"></i> Approve Company
      </a>
     @elseif($company->status == 'Not Approved')
      <a href="{{ route('eac.portal.company.reactivate', $company->id) }}" class="btn btn-success">
       <i class="fas fa-redo"></i> Reactivate Company
      </a>
     @endif
    </div>
   </div>
  </form>
  <div class="row thisone m-0 mb-xl-5">
   <div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
    <div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist" aria-orientation="vertical">
     <a class="nav-link complete active" id="xdetails-tab" data-toggle="pill" href="#xdetails" role="tab" aria-controls="xdetails" aria-selected="true">
      <span>Company Details</span>
     </a>
     <a class="nav-link @if($company->desc) complete @endif" id="xwebdesc-tab" data-toggle="pill" href="#xwebdesc" role="tab" aria-controls="xwebdesc" aria-selected="false">
      <span>Website Description</span>
     </a>
     <a class="nav-link @if($company->departments->count() > 0) complete @endif" id="xcontacts-tab" data-toggle="pill" href="#xcontacts" role="tab" aria-controls="xcontacts" aria-selected="false">
      <span>Departments</span>
     </a>
     <a class="nav-link @if($company->users->count() > 0) complete @endif" id="xusers-tab" data-toggle="pill" href="#xusers" role="tab" aria-controls="xusers" aria-selected="false">
      <span>Assigned Users</span>
     </a>
    </div>
   </div>
   <div class="col-sm-9 col-xl p-0">
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
     <div class="tab-pane fade show active" id="xdetails" role="tabpanel" aria-labelledby="xdetails-tab">
      <form name="" method="POST" action="{{ route('eac.portal.company.update') }}">
       {{ csrf_field() }}
       <div class="card-body">
        <div class="row">
         <div class="col-sm mb-3">
          <label class="d-block label_required">Company Name</label>
          <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"  value="{{ $company->name }}"placeholder="Name">
          <div class="invalid-feedback">
           {{ $errors->first('name') }}
          </div>
         </div>
         <div class="col-sm-5 mb-3">
          <label class="d-block label_required">Abbr<span class="d-sm-none d-md-inline">eviation</span></label>
          <input type="text" class="form-control{{ $errors->has('abbr') ? ' is-invalid' : '' }}" name="abbr" value="{{ $company->abbr }}" placeholder="Abbreviation">
          <div class="invalid-feedback">
           {{ $errors->first('abbr') }}
          </div>
         </div>
        </div>
        <div class="row">
         <div class="col-lg-12 mb-3">
          <label class="d-block">Website</label>
          <input type="text" class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}" name="website" value="{{ $company->site ? $company->site : '' }}" placeholder="Website">
          <div class="invalid-feedback">
           {{ $errors->first('website') }}
          </div>
         </div>
         <div class="col-sm mb-3">
          <label class="d-block">Phone</label>
          <input type="text" class="form-control" name="phone_main" @if($company->phone_main) value="{{ $company->phone->number }}" @endif>
         </div>
         <div class="col-sm mb-3">
          <label class="d-block">Email</label>
          <input type="text" class="form-control" name="email_main" @if($company->email_main) value="{{ $company->email_main }}" @endif>
         </div>
        </div>
        <label class="d-block">Address</label>
        <div class="row m-md-0">
         <div class="col-md mb-1 mb-md-3 p-md-0">
          <input type="text" class="form-control{{ $errors->has('addr1') ? ' is-invalid' : '' }}" name="addr1" value="{{ $company->address->addr1  }}" placeholder="Street Address">
         </div>
         <div class="col-md-5 mb-3 p-md-0 pl-md-1">
          <input type="text" class="form-control{{ $errors->has('addr2') ? ' is-invalid' : '' }}" name="addr2" value="{{ $company->address->addr2 ? $company->address->addr2 : '' }}" placeholder="Building, Suite, Floor, etc">
         </div>
        </div>
        <div class="invalid-feedback">
         {{ $errors->first('addr1') }}
        </div>
        <div class="row">
         <div class="col-md-7 col-lg-6 mb-3">
          <label class="d-block label_required">Country</label>
          <select class="select2 form-control {{ $errors->has('country') ? ' is-invalid' : '' }}" id="country_id" name="country">
           <option disabled hidden selected value="">-- Select --</option>
           @foreach($countries as $country)
            <option value="{{$country->id}}" {{ $company->country_id == $country->id? 'selected' : ''  }}>{{$country->name}}</option>
           @endforeach
          </select>
          <div class="invalid-feedback">
           {{ $errors->first('country') }}
          </div>
         </div>
         <div class="col-md-5 col-lg-6 mb-3">
          <label class="d-block"  id="city_lbl">City</label>
          <input type="text"  id="city_input"  class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ $company->address->city }}" placeholder="City">
          <div class="invalid-feedback">
           {{ $errors->first('city') }}
          </div>
         </div>
         <div class="col-sm-7 col-lg-6 mb-3">
          <label class="d-block"  id="state_lbl">State</label>          
          <select class="form-control{{ $errors->has('company_state') ? ' is-invalid' : '' }}" name="company_state" id="state_option">
           <option disabled hidden selected value="">-- Select --</option>
           @foreach($state as $state)
            <option value="{{$state->id}}" {{ $company->address->state_province == $state->id ? 'selected' : ''}} >{{$state->name}}</option>
           @endforeach
          </select>
          <input type="text" placeholder="Province" name="company_state" id="state_text" class="form-control" value="{{ $country->name != 'United States' ? $company->address->state_province : ''}}">
          <div class="invalid-feedback">
           {{ $errors->first('province') }}
          </div>
         </div>
         <div class="col-sm-5 col-lg-6 mb-3">
          <label class="d-block" id="zip_lbl">Zip</label>
          <input type="text" id="zip_input" class="form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" name="zipcode"  value="{{ $company->address->zipcode }}" placeholder="Zipcode">
          <div class="invalid-feedback">
           {{ $errors->first('zipcode') }}
          </div>
         </div>
        </div>
       </div>
       <div class="card-footer d-flex justify-content-end">
        <input type="hidden" name="company_id" value="{{$company->id}}">
        <input type="hidden" name="address_id" value="{{$company->address_id}}">
        <button class="btn btn-success" type="submit">
         <i class="far fa-check"></i> Update
        </button>
       </div>
      </form>
     </div><!-- /.tab-pane -->
     <div class="tab-pane fade" id="xwebdesc" role="tabpanel" aria-labelledby="xwebdesc-tab">
      <form name="" method="POST" action="{{ route('eac.portal.company.desc.update') }}" enctype="multipart/form-data">
       {{ csrf_field() }}
       <div class="card-body">
        <h5 class="mb-3">
         <strong>Description</strong> to be viewed on the EAC website
        </h5>
        <textarea class="form-control basic-editor" name="desc" rows="10">{{ $company->desc }}</textarea>
       </div>
       <div class="card-footer d-flex justify-content-end">
        <input type="hidden" name="company_id" value="{{$company->id}}">
        <button class="btn btn-success" type="submit">
         <i class="far fa-check"></i> Update
        </button>
       </div>
      </form>
     </div><!-- /.tab-pane -->
     <div class="tab-pane fade" id="xcontacts" role="tabpanel" aria-labelledby="xcontacts-tab">
      <div class="card-body">
       <h5 class="mb-3">
        {{ $company->name }} Departments
        @if($company->departments->count() > 0)
         <span class="badge badge-dark">
          {{$company->departments->count()}}
         </span>
        @endif
       </h5>
       @if($company->departments->count() > 0)
        <div class="row">
         @foreach($company->departments as $department)
          <div class="col-md-6 mb-3">
           <div class="card h-100 border-light bs-no border">
            <div class="card-body p-3">
             <h6 class="mb-2 strong">
              {{$department->name}}
             </h6>
             <div class="row m-0 small mb-1">
              <div class="col-auto p-0">
               <i class="text-secondary fa-fw fas fa-phone fa-rotate-90"></i>
              </div>
              <div class="col pl-2 pr-0 wraphelp">
               @if($department->phone_id)
                {{$department->phone->number}}
               @else
                <span class="text-muted">N/A</span>
               @endif
              </div>
             </div><!-- /.row -->
             <div class="row m-0 small">
              <div class="col-auto p-0">
               <i class="text-secondary fa-fw fas fa-envelope"></i>
              </div>
              <div class="col pl-2 pr-0 wraphelp">
               @if($department->email)
                {{$department->email}}
               @else
                <span class="text-muted">N/A</span>
               @endif
              </div>
             </div><!-- /.row -->
            </div>
            <div class="card-footer alert-secondary p-2 d-flex justify-content-between">
             <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editDept{{$department->id}}" title="Edit Department">
              <i class="far fa-fw fa-edit"></i> Edit
             </button>
             <button type="button" class="btn btn-danger btn-sm" onclick="Confirm_Delete('{{$department->id}}')" href="#" title="Delete Department">
              <i class="far fa-fw fa-times"></i> Delete
             </button>
            </div>
           </div>
          </div>
          @include('include.portal.modals.company.editdepartment', $department)
         @endforeach
        </div>
       @else
        <p class="text-muted m-0">
         <i class="fal fa-info-circle"></i> No departments available
        </p>
       @endif
      </div>      
      <div class="card-footer d-flex justify-content-end">
       <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNewDept">
        Add Department
       </button>
      </div>
     </div><!-- /.tab-pane -->
     <div class="tab-pane fade" id="xusers" role="tabpanel" aria-labelledby="xusers-tab">
      <div class="card-body">
       <h5 class="mb-3">
        {{ $company->name }} Users
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
      <div class="card-footer">
       <label class="d-block">Assign Users to {{ $company->name }}:</label>
       <form action="{{ route('eac.portal.company.user.assignmultiple') }}" method="post">
        {{ csrf_field() }}
        <div class="row m-sm-0">
         <div class="col-sm mb-3 mb-sm-0 p-sm-0">
          <select name="select_users[]" class="form-control select2" multiple required="required">
           @foreach(App\User::all() as $user)
            @if($user->company_id != $company->id || !($user->company_id))
             <option value="{{$user->id}}">
              {{$user->full_name}} ({{$user->email}})
             </option>
            @endif
           @endforeach
          </select>
         </div>
         <input type="hidden" name="company_id" value="{{ $company->id}}">
         <div class="col-sm-auto mb-3 mb-sm-0 p-sm-0">
          <button  type="submit" class="btn btn-success">
           Assign Users
          </button>          
         </div>
        </div>
       </form>
      </div>
     </div><!-- /.tab-pane -->
    </div>
   </div>
  </div>
 </div>
  {{--
   <div class="row">
    <div class="col-md col-lg-4 col-xl-12">
     <form name="" method="POST" action="{{ route('eac.portal.company.update') }}">
      {{ csrf_field() }}
      <div class="row">
       <div class="col-xl">
        <div class="card card-body mb-5">
         <h5 class="text-gold mb-2">
          Company Information
         </h5>
         <div class="row">
          <div class="col-sm col-lg-12 mb-3">
           <label class="d-block">Company Name</label>
           <input type="text" class="form-control" name="name" value="{{ $company->name }}">
          </div>
          <div class="col-sm col-md-3 col-lg-12 mb-3">
           <label class="d-block">Abbreviation</label>
           <input type="text" class="form-control" name="abbr" value="{{ $company->abbr }}">
          </div>      
          <div class="col-md col-lg-12 mb-3">
           <label class="d-block">Company Website</label>
           <input type="text" class="form-control" name="website" value="{{ $company->site ? $company->site : '' }}">
          </div>
         </div>
         <div class="mb-2">
          <label class="d-block">Street Address</label>
          <input type="text" class="form-control mb-1" name="addr1" placeholder="Street name" value="{{ $company->address->addr1 }}">
          <input type="text" class="form-control mb-2" name="addr2" placeholder="" value="{{$company->address->addr2}}">
         </div>
         <div class="row">
          <div class="col-sm col-lg-12 mb-2">
           <label class="d-block">City</label>
           <input type="text" class="form-control" name="city" value="{{ $company->address->city }}">
          </div>
          @if($company->address->state_province != NULL)
          <div class="col-sm col-lg-12 col-xl mb-2">
           <label class="d-block">State</label>
            <select class="select2 form-control{{ $errors->has('company_state') ? ' is-invalid' : '' }}" name="company_state">
              <option disabled hidden selected value="">-- Select --</option>
              @foreach($state as $state)
               <option value="{{$state->id}}" {{ $company->address->state->id == $state->id? 'selected' : ''  }}>{{$state->abbr}}</option>
              @endforeach
             </select>
          </div>
          @endif
       
          <div class="col-sm col-lg-12 col-xl mb-2">
           <label class="d-block">Zip</label>
           <input type="text" class="form-control" name="zipcode" value="{{ $company->address->zipcode }}">
          </div>
         </div>
         <div class="mb-2">
          <label class="d-block">Country</label>
          <!-- <input type="text" class="form-control" name="address_country" value="{{ $company->address->country->name }}"> -->
          <select class="form-control" name="country">
           <option disabled hidden selected value="">-- Select --</option>
           @foreach($countries as $countries)
            <option value="{{$countries->id}}" {{ $company->country_id == $countries->id? 'selected' : ''  }}>{{$countries->name}}</option>
           @endforeach
          </select>
         </div>
         <div class="row m-1">
          <input type="hidden" name="company_id" value="{{$company->id}}">
          <input type="hidden" name="address_id" value="{{$company->address_id}}">
          <button class="btn btn-success" type="submit">
           <i class="far fa-check"></i> Update
          </button>
         </div>
        </div>
       </div>
       <div class="col-xl">
        <div class="card card-body mb-5">
         <h5 class="text-gold mb-2">
          Company Contacts
         </h5>
         <div class="mb-2">
          <label>Main</label>
          <div class="input-group mb-2" title="Main Phone">
           <div class="input-group-prepend">
            <span class="input-group-text">
             <i class="fas fa-phone"></i> <span class="sr-only">Main Phone</span> 
            </span>
           </div>
           <input type="text" class="form-control pl-1" name="phone_main" @if($company->phone_main) value="{{ $company->phone->number }}" @endif>
          </div>
          <div class="input-group" title="Main Email">
           <div class="input-group-prepend">
            <span class="input-group-text">
             <i class="fas fa-at"></i> <span class="sr-only">Main Email</span> 
            </span>
           </div>
           <input type="text" class="form-control pl-1" name="email_main" @if($company->email_main) value="{{ $company->email_main }}" @endif>
          </div>
         </div>
         @foreach($company->departments as $department)
          <div class="mb-2">
           <label>{{ $department->name }}</label>      
           <div class="input-group mb-2" title="{{ $department->name }} Phone">
            <div class="input-group-prepend">
             <span class="input-group-text">
              <i class="fas fa-phone"></i> <span class="sr-only">{{ $department->name }} Phone</span>
             </span>
            </div>
            <input type="text" required class="form-control" name="phone" @if($department->phone_id) value="{{ $department->phone->number }}" @endif>
           </div>
           <div class="input-group" title="{{ $department->name }} Email">
            <div class="input-group-prepend">
             <span class="input-group-text">
              <i class="fas fa-at"></i> <span class="sr-only">{{ $department->name }} Email</span>
             </span>
            </div>
            <input type="email" required class="form-control" name="email" @if($department->email) value="{{ $department->email }}" @endif>
           </div>
           <div class="input-group text-center mt-3" >
            <!-- <a title="#" href="#" data-toggle="modal" data-target="#editDept">
             <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit</span>
            </a> -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editDept{{$department->id}}">
             <i class="far fa-edit" aria-hidden="true"></i>
            </button>
             &nbsp;
            <button type="button" onclick="Confirm_Delete('{{$department->id}}')" href="#" class="btn btn-danger">
             <i class="far fa-trash" aria-hidden="true"></i> <span class="sr-only">Delete</span>
            </button>
           </div>
          </div>
         @endforeach
         <div class="mt-5">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNewDept">
           Add Department
          </button>
         </div>
        </div>
       </div>
      </div>
     </form>
     @foreach($company->departments as $department)
      <div class="modal fade" id="editDept{{$department->id}}" tabindex="-1" role="dialog" aria-labelledby="editDeptLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
         <div class="modal-header p-2">
          <h5 class="m-0">
           Edit Department
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <i class="fal fa-times"></i>
          </button>
         </div>
         <form method="post" action="{{ route('eac.portal.company.department.update') }}">
          {{ csrf_field() }}
          <input type="hidden" name="company_id" value="{{ $company->id }}"/>
          <input type="hidden" name="department_id" value="{{ $department->id}}"/>
          <input type="hidden" name="phone_id" value="{{ $department->phone_id}}"/>
          <input type="hidden" name="country_id" value="{{ $company->country_id}}"/>
          <div class="modal-body p-3">
           <div class="mb-3">
            <label class="d-block">Department Name</label>
            <input type="text" class="form-control" name="name" value="{{ $department->name }}">
           </div>
           <div class="row">
            <div class="col-sm mb-3">
             <label class="d-block">Phone Number</label>
             <input type="number" class="form-control" name="phone" @if($department->phone_id) value="{{ $department->phone->number }}" @endif>
            </div>
            <div class="col-sm mb-3">
             <label class="d-block">Email Address</label>
             <input type="email" class="form-control" name="email" value="{{ $department->email }}">
            </div>
           </div><!-- /.row -->
          </div>
          <div class="modal-footer p-2 d-flex justify-content-between">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
           <button type="submit" class="btn btn-success">
            Update
           </button>
          </div>
         </form>
        </div>
       </div>
      </div>
     @endforeach
    </div>
    <div class="col-xl-12">
     <div class="card card-body mb-5">
      <h5 class="text-gold mb-2">Assigned Users</h5>
      <div class="table-responsive">
       <table class="table SObasic table-sm table-striped table-hover">
        <thead>
         <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Company</th>
          <th></th>
         </tr>
        </thead>
        <tbody>
         @foreach(App\User::all() as $user)
          @if($user->company_id == $company->id || !($user->company_id))
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
            @if($user->company_id)
             @if($user->company_id == $company->id)
              {{ $user->company->name }}
             @else
              {{ $user->company->name }}
             @endif
            @endif
           </td>
           <td class="text-center">              
            @if($user->company_id)
             @if($user->company_id == $company->id)
              <a href="{{ route('eac.portal.company.user.remove', [$company->id, $user->id]) }}" class="btn btn-danger btn-sm" title="Remove User">
               <i class="fal fa-minus"></i> Unassign
              </a>
             @else
              <small class="text-muted">N/A</small>
             @endif
            @else
             <a href="{{ route('eac.portal.company.user.add', [$company->id, $user->id]) }}" class="btn btn-outline-success btn-sm" title="Add User">
              <i class="fal fa-plus"></i> Assign
             </a>
            @endif
           </td>
          </tr>
          @endif
         @endforeach
        </tbody>
       </table>
      </div>
     </div>
    </div><!-- /.row -->
   </div>
  --}}
 </div><!-- end .editData -->

 <div class="modal fade" id="addNewDept" tabindex="-1" role="dialog" aria-labelledby="addNewDeptLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
      Add New Department
     </h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <form method="post" action="{{ route('eac.portal.company.department.create') }}">
     {{ csrf_field() }}
     <input type="hidden" name="company_id" value="{{ $company->id }}"/>
     <div class="modal-body p-3">
      <div class="mb-3">
       <label class="d-block">Department Name</label>
       <input type="text" class="form-control" name="name">
      </div>
      <div class="row">
       <div class="col-sm mb-3">
        <label class="d-block">Phone Number</label>
        <input type="number" class="form-control" name="phone">
       </div>
       <div class="col-sm mb-3">
        <label class="d-block">Email Address</label>
        <input type="email" class="form-control" name="email">
       </div>
      </div><!-- /.row -->
     </div>
     <div class="modal-footer p-2 d-flex justify-content-between">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      <button type="submit" class="btn btn-success">
       Save
      </button>
     </div>
    </form>
   </div>
  </div>
 </div>

 
@endsection

@section('scripts')

<script type="text/javascript">
$(document).ready(function () {
   $('.select2').select2();
    $( "#state_text" ).hide();
    $('#state_text').attr("disabled", true);
    $("#state").prop('required',false);
    $("#country_id").on('change',function(){
      if($("#country_id option:selected").text() != 'United States'){
        $("#zip_lbl").text('Postal Code');
        $("#zip_input").attr('placeholder','Postal Code');
        $("#city_lbl").text('Town/City');
        $("#city_input").attr('placeholder','Town/City');
        $("#state_lbl").text('Province');
        $( "#state_option" ).hide();
        $('#state_option').attr("disabled", true);
        $( "#state_text" ).show();
        $('#state_text').attr("disabled", false);

      }else{
        $( "#state_text" ).hide();
        $('#state_text').attr("disabled", true);
        $( "#state_option" ).show();
        $('#state_option').attr("disabled", false);
        $("#city_lbl").text('City');
        $("#city_input").attr('placeholder','City');
        $("#zip_lbl").text('Zip');
        $("#zip_input").attr('placeholder','Zip Code');
      }

    });

    if($("#country_id option:selected").text() != 'United States'){
        $("#zip_lbl").text('Postal Code');
        $("#zip_input").attr('placeholder','Postal Code');
        $("#city_lbl").text('Town/City');
        $("#city_input").attr('placeholder','Town/City');
        $("#state_lbl").text('Province');
        $( "#state_option" ).hide();
        $('#state_option').attr("disabled", true);
        $( "#state_text" ).show();
        $('#state_text').attr("disabled", false);
      }
});
function Confirm_Delete(param)
{

 swal({
  title: "Are you sure?",
  text: "Want to delete it",
  icon: "warning",
  buttons: [
   'No, cancel it!',
   'Yes, I am sure!'
  ],
  dangerMode: true,
 }).then(function (isConfirm) {
  if (isConfirm) {
   swal({
    title: 'Successfull!',
    text: 'Content deleted!',
    icon: 'success'
   }).then(function () {
    $.get("{{route('eac.portal.company.department.delete')}}",
      {
       id: param
      });
    // return false;
    swal.close();
    var redirect_url = '<?php echo route('eac.portal.company.edit', $company->id); ?>';
    $(location).attr('href', redirect_url); // <--- submit form programmatically
   });
  } else {
   swal("Cancelled", "Operation cancelled", "error");
  }
 })
}
</script>
@endsection
