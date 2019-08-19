@extends('layouts.portal')

@section('styles')
@endsection

@section('title')
 Website Properties
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{route('eac.portal.settings')}}">Supporting Content</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
     @yield('title')
    </li>
   </ol>
  </nav>
  <h6 class="m-0">
   Supporting Content
  </h6>
  <h2 class="m-0">
   @yield('title')
  </h2>
 </div><!-- end .titleBar -->
  <div class="actionBar">
     
    <a  class="btn btn-success" title="List Page" href="{{route('eac.portal.settings.manage.website.properties.index')}} ">
       <i class="far fa-list" ></i> List</span>
    </a>
    </div><!-- end .actionBar -->
 <div class="viewData">
  <div class="row">
   <div class="col-lg-8 col-xl-auto">
    <div class="mb-3 mb-xl-5">
     <form action="{{ route('eac.portal.settings.manage.website.properties.store') }}" class="x" method="post" enctype='multipart/form-data'>
      {{ csrf_field() }}
      <div class="card card-body mb-0">
       <h5 class="text-gold">Company Settings</h5>
       <div class="row">
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Company Name</label>
          <input type="text"  class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}"  name="company_name" />
           <div class="invalid-feedback">
          {{ $errors->first('company_name') }}
         </div>
         </div>

        </div>
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Company Established</label>
          <input type="number"  class="form-control{{ $errors->has('company_est') ? ' is-invalid' : '' }}"  name="company_est" />
          <div class="invalid-feedback">
          {{ $errors->first('company_est') }}
         </div>
         </div>
        </div>
       </div>
       <div class="mb-3">
        <label for="" class="d-block">Street Address</label>
        <input type="text" class="form-control mb-2 {{ $errors->has('company_addr_1') ? ' is-invalid' : '' }}"  name="company_addr_1"  />
          <div class="invalid-feedback">
          {{ $errors->first('company_addr_1') }}
         </div>
        <input type="text" class="form-control"  class="form-control" name="company_addr_2"  />
        
       </div>
       <div class="row">
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">City</label>
          <input type="text" class="form-control{{ $errors->has('company_city') ? ' is-invalid' : '' }}"   name="company_city"  />
          <div class="invalid-feedback">
          {{ $errors->first('company_city') }}
         </div>
         </div>
        </div>
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">State</label>
          
          <select class="select2 form-control{{ $errors->has('company_state') ? ' is-invalid' : '' }}" name="company_state">
          <option disabled hidden selected value="">-- Select --</option>
          @foreach($state as $state)
           <option value="{{$state->name}}">{{$state->name}}</option>
          @endforeach
         </select>
         </div>
        </div>
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">Postal Code</label>
          <input type="number"  class="form-control{{ $errors->has('company_zip') ? ' is-invalid' : '' }}"  name="company_zip"  />
          <div class="invalid-feedback">
          {{ $errors->first('company_zip') }}
         </div>
         </div>
        </div>
       </div>
       <div class="row">
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">Phone</label>
          <input type="number" class="form-control{{ $errors->has('company_phone_1') ? ' is-invalid' : '' }}"  name="company_phone_1"  />
          <div class="invalid-feedback">
          {{ $errors->first('company_phone_1') }}
         </div>
         </div>
        </div>
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">Phone <small>(alternate)</small></label>
          <input type="number" class="form-control"   name="company_phone_2"  />
        
         </div>
        </div>
       </div>
       <h5 class="text-gold">Website Settings</h5>
       <div class="row">
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Email Address</label>
          <input type="email"  name="company_email" class="form-control{{ $errors->has('company_email') ? ' is-invalid' : '' }}"  />
         <div class="invalid-feedback">
          {{ $errors->first('company_email') }}
         </div>
         </div>
        </div>
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Website URL</label>
          <input type="text"  name="company_url" class="form-control{{ $errors->has('company_url') ? ' is-invalid' : '' }}"  />
          
         </div>
         <div class="invalid-feedback">
          {{ $errors->first('company_url') }}
         </div>
        </div>
       </div>
       <div class="mb-3">
        <label for="" class="d-block">Company Logo <small>({{config('eac.storage.file.type')}})</small></label>
        <div class="input-group">
         <input type="file" class="form-control" name="company_logo"  />
        </div>
        <div class="d-flex justify-content-between flex-wrap">
         <div>
          <div class="invalid-feedback">
           {{ $errors->first('company_name') }}
          </div>
         </div>
         <div>
          <label class="d-block small">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
         </div>
        </div>
       </div>
      </div>
      <div class="card-footer">
       <button class="btn btn-success" type="submit" value="save">
        <i class="far fa-check"></i> Save Changes
       </button>
      </div>
     </form>
    </div>
   </div>
  </div>
 </div>
 <!-- end .viewData -->

@endsection
@section('scripts')
@endsection
