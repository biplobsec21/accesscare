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
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning">
      <i class="far fa-arrow-left"></i> Go back
     </a>
    <a  class="btn btn-success" title="Edit Page" href="{{route('eac.portal.settings.manage.website.properties.edit', $rows->id)}} ">
       <i class="far fa-edit" ></i> Edit Page</span>
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
          <input type="text" value="{{$rows->name}}" readonly=""  class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}"  name="company_name" />
           <div class="invalid-feedback">
          {{ $errors->first('company_name') }}
         </div>
         </div>

        </div>
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Company Established</label>
          <input type="text" class="form-control" name="company_est" readonly="" value="{{$rows->establishment}}" />
         </div>
        </div>
       </div>
       <div class="mb-3">
        <label for="" class="d-block">Street Address</label>
        <input type="text" class="form-control mb-2" name="company_addr_1" readonly="" value="{{$rows->addr1}}" />
        <input type="text" class="form-control" name="company_addr_2" readonly="" value="{{$rows->addr2}}" />
       </div>
       <div class="row">
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">City</label>
          <input type="text" class="form-control" name="company_city" readonly="" value="{{$rows->city}}" />
         </div>
        </div>
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">State</label>
          <select class="select2 form-control{{ $errors->has('company_state') ? ' is-invalid' : '' }}" name="company_state">
          <!-- <option disabled hidden selected value="">-- Select --</option> -->
          @foreach($state as $state)
          @if($rows->state == $state->name)
           <option disabled value="{{$state->name}}" {{ $rows->state == $state->name? 'selected' : ''  }}>{{$state->name}}</option>
           @endif
          @endforeach
         </select>

         </div>
        </div>
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">Postal Code</label>
          <input type="text" class="form-control" name="company_zip" readonly="" value="{{$rows->zip}}" />
         </div>
        </div>
       </div>
       <div class="row">
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">Phone</label>
          <input type="text" class="form-control" name="company_phone_1" readonly="" value="{{$rows->phone1}}" />
         </div>
        </div>
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">Phone <small>(alternate)</small></label>
          <input type="text" class="form-control" name="company_phone_2" readonly="" value="{{$rows->phone2}}" />
         </div>
        </div>
       </div>
       <h5 class="text-gold">Website Settings</h5>
       <div class="row">
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Email Address</label>
          <input type="text" class="form-control" name="company_email" readonly="" value="{{$rows->email}}" />
         </div>
        </div>
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Website URL</label>
          <input type="text" class="form-control" name="company_url" readonly="" value="{{$rows->website}}" />
         </div>
        </div>
       </div>
       <div class="mb-3">
        <label for="" class="d-block">Company Logo</label>
         <img src="{{asset($rows->logo)}}" class="propsLogo">
        
       </div>
      </div>
      <div class="card-footer">
       <!-- <button class="btn btn-success" type="submit" value="save">
        <i class="far fa-check"></i> Save Changes
       </button> -->
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
