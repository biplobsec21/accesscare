@extends('layouts.portal')

@section('title')
	Edit Company
@endsection

@section('content')
 <div class="titleBar mb-0">
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
       <a href="{{ route('eac.portal.company.show', $company->id) }}">View Company</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
       Edit Company: {{ $company->name }}
      </li>
     </ol>
    </div>
    <div class="d-none d-sm-block col-sm-auto ml-sm-auto">
     <div class="small">
      @if(!is_null($company->last_seen))
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
  <h5 class="m-0">
   @yield('title')
  </h5>
  <h2 class="m-0">
   {{ $company->name }} ({{ $company->abbr }})
  </h2>
  <div class="small d-sm-none">
   @if(!is_null(Auth::user()->last_seen))
    <strong>Last Updated:</strong>
    @php
     $time = $user->updated_at;
     $time->tz = "America/New_York";
     echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
    @endphp
   @endif
  </div>
 </div><!-- end .titleBar -->

 <div class="row align-items-xl-end">
  <div class="col-xl">
   <div class="actionBar">
    <a href="{{ url()->previous() }}" class="btn btn-light">
     <i class="fal fa-angle-double-left"></i> Go Back
    </a>
    <a href="{{ route('eac.portal.company.list') }}" class="btn btn-primary">
     <i class="fal fa-hospitals"></i> All Companies
    </a>
    <a href="{{ route('eac.portal.company.show', $company->id) }}" class="btn btn-info">
     <i class="fal fa-hospital-alt"></i> View Company
    </a>

   </div>
  </div>
  <div class="col-xl">
   <label class="strong upper small m-0">Super Admin Actions</label>
   <div class="actionBar">
    <a href="#" class="btn btn-outline-danger disabled">
     <i class="fal fa-ban"></i> Suspend Company
    </a>
   </div><!-- end .actionBar -->
  </div>
 </div>


 <div class="viewData">
  <div class="row">
   <div class="col-md-4 m-b-10">
    <h5>
     Company Information
    </h5>
    <div class="card">
     <div class="card-body">
      <ul class="list-group list-group-flush">
       <li class="list-group-item">
        <strong class="upper d-block">Company Name</strong>
        <input type="text" class="form-control" name="name" value="{{ $company->name }}">
       </li>
       <li class="list-group-item">
        <strong class="upper d-block">Company Abbreviation</strong>
        <input type="text" class="form-control" name="abbr" value="{{ $company->abbr }}">
       </li>
       <li class="list-group-item">
        <strong class="upper d-block">Company Address</strong>
        @if(isset($company->address))
         <input type="text" class="form-control" name="addr1" value="{{ $company->address->addr1 }}">
         @if(isset($company->address->addr2))
          <input type="text" class="form-control" name="addr2" value="{{ $company->address->addr2 }}">
         @endif
         <input type="text" class="form-control" name="city" value="{{ $company->address->city }}">
         <input type="text" class="form-control" name="state" value="{{ $company->address->state->abbr }}">
         <input type="text" class="form-control" name="zipcode" value="{{ $company->address->zipcode }}">
         <input type="text" class="form-control" name="address_country"
             value="{{ $company->address->country->name }}">
        @else
         No Address data.
        @endif
       </li>
      </ul>
     </div>
    </div>
   </div>
   <div class="col-md-8 m-b-10">
    <h5>
     Department Contacts
    </h5>
    <div class="card m-b-30">
     <div class="card-body">
      <div class="row">
       <div class="col-4">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
         <a class="nav-link active" id="v-pills-main-tab" data-toggle="pill" href="#v-pills-main" role="tab"
           aria-controls="v-pills-main" aria-selected="true">Main</a>
         @foreach($company->department as $department)
          <a class="nav-link" id="v-pills-{{ $department->id }}-tab" data-toggle="pill"
            href="#v-pills-{{ $department->id }}" role="tab" aria-controls="v-pills-{{ $department->id }}"
            aria-selected="false">{{ $department->name }}</a>
         @endforeach
         <a class="nav-link text-success" style="" id="v-pills-new-tab" data-toggle="pill" href="#v-pills-new"
           role="tab"
           aria-controls="v-pills-new" aria-selected="false">New</a>
        </div>
       </div>
       <div class="col-8">
        <div class="tab-content" id="v-pills-tab">
         <div class="tab-pane fade show active" id="v-pills-main" role="tabpanel"
            aria-labelledby="v-pills-main-tab">
          <ul class="list-group list-group-flush">
           <li class="list-group-item">
            <strong class="upper d-block">Main Website</strong>
            <input type="text" class="form-control" name="site"
                @if($company->site) value="{{ $company->site }}" @endif>
           </li>
           <li class="list-group-item">
            <strong class="upper d-block">Main Phone</strong>
            <input type="text" class="form-control" name="phone_main"
                @if($company->phone_main) value="{{ $company->phone_main }}" @endif>
           </li>
           <li class="list-group-item">
            <strong class="upper d-block">Main Email</strong>
            <input type="text" class="form-control" name="email_main"
                @if($company->email_main) value="{{ $company->email_main }}" @endif>
           </li>
          </ul>
         </div>
         @foreach($company->department as $department)
          <div class="tab-pane" id="v-pills-{{ $department->id }}" role="tabpanel"
             aria-labelledby="v-pills-{{ $department->id }}-tab">
           <ul class="list-group list-group-flush">
            <li class="list-group-item">
             <strong class="upper d-block">{{ $department->name }} Phone</strong>
             <input type="text" class="form-control" name="phone"
                 @if($department->phone_id) value="{{ $department->phone->number }}" @endif>
            </li>
            <li class="list-group-item">
             <strong class="upper d-block">{{ $department->name }} Email</strong>
             <input type="text" class="form-control" name="email"
                 @if($department->email) value="{{ $department->email }}" @endif>
            </li>
           </ul>
          </div>
         @endforeach
         <div class="tab-pane" id="v-pills-new" role="tabpanel" aria-labelledby="v-pills-new-tab">
          <form method="post" action="{{ route('eac.portal.company.department.create') }}">
           {{ csrf_field() }}
           <ul class="list-group list-group-flush">
            <li class="list-group-item">
             <input type="hidden" name="company_id" value="{{ $company->id }}"/>
             <strong class="upper d-block">Name</strong>
             <input type="text" class="form-control" name="name">
            </li>
            <li class="list-group-item">
             <strong class="upper d-block">Phone</strong>
             <input type="text" class="form-control" name="phone">
            </li>
            <li class="list-group-item">
             <strong class="upper d-block">Email</strong>
             <input type="text" class="form-control" name="email">
            </li>
            <li class="list-group-item">
             <button type="submit" class="btn btn-success">
              Save
             </button>
            </li>
           </ul>
          </form>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
    <h5>
     Associated Users
    </h5>
    <div class="card m-b-30">
     <div class="card-body">
      <ul class="list-group list-group-flush">
       @foreach(App\User::all() as $user)
        <li class="list-group-item p-5">
         <div class="row">
          <div class="col">
           <a href="{{ route('eac.portal.user.show', $user->id) }}">{{ $user->full_name }}</a>
          </div>
          <div class="col text-right">
           @if($user->company_id)
            @if($user->company_id == $company->id)
             {{ $user->company->name }}
             <a href="{{ route('eac.portal.company.user.remove', [$company->id, $user->id]) }}"
               class="btn btn-danger" style="padding: 0 6.5px">
              <i class="far fa-times" style="vertical-align: middle;"></i>
             </a>
            @else
             {{ $user->company->name }}
             <a href="#" class="btn btn-secondary disabled" style="padding: 0 6.5px">
              <i class="far fa-times" style="vertical-align: middle;"></i>
             </a>
            @endif
           @else
            <a href="{{ route('eac.portal.company.user.add', [$company->id, $user->id]) }}"
              class="btn btn-warning" style="padding: 0 5px">
             <i class="far fa-plus" style="vertical-align: middle;"></i>
            </a>
           @endif
          </div>
         </div>
        </li>
       @endforeach
      </ul>
     </div>
    </div>
   </div>
  </div>
 </div><!-- end .editData -->
@endsection

@section('scripts')
@endsection
