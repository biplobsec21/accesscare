@extends('layouts.portal')

@section('styles')
@endsection

@section('title')
 Site Properties
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
 
 <div class="viewData">
  <div class="row">
   <div class="col-lg-8 col-xl-auto">
    <div class="mb-3 mb-xl-5">
     <form action="" class="x" method="post">
      <div class="card card-body mb-0">
       <h5 class="text-gold">Company Settings</h5>
       <div class="row">
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Company Name</label>
          <input type="text" class="form-control" name="company_name" value="Early Access Care LLC" />
         </div>
        </div>
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Company Established</label>
          <input type="text" class="form-control" name="company_est" value="" />
         </div>
        </div>
       </div>
       <div class="mb-3">
        <label for="" class="d-block">Street Address</label>
        <input type="text" class="form-control mb-2" name="company_addr_1" value="40 Mungertown Road" />
        <input type="text" class="form-control" name="company_addr_2" value="" />
       </div>
       <div class="row">
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">City</label>
          <input type="text" class="form-control" name="company_city" value="Madison" />
         </div>
        </div>
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">State</label>
          <select class="form-control select2" name="company_state">
           <option disabled hidden selected value="">-- Select --</option>
           <option value="AK">AK</option>
           <option value="AL">AL</option>
           <option value="AR">AR</option>
           <option value="AZ">AZ</option>
           <option value="CA">CA</option>
           <option value="CO">CO</option>
           <option value="CT" selected="selected">CT</option>
           <option value="DC">DC</option>
           <option value="DE">DE</option>
           <option value="FL">FL</option>
           <option value="GA">GA</option>
           <option value="HI">HI</option>
           <option value="IA">IA</option>
           <option value="ID">ID</option>
           <option value="IL">IL</option>
           <option value="IN">IN</option>
           <option value="KS">KS</option>
           <option value="KY">KY</option>
           <option value="LA">LA</option>
           <option value="MA">MA</option>
           <option value="MD">MD</option>
           <option value="ME">ME</option>
           <option value="MI">MI</option>
           <option value="MN">MN</option>
           <option value="MO">MO</option>
           <option value="MS">MS</option>
           <option value="MT">MT</option>
           <option value="NC">NC</option>
           <option value="ND">ND</option>
           <option value="NE">NE</option>
           <option value="NH">NH</option>
           <option value="NJ">NJ</option>
           <option value="NM">NM</option>
           <option value="NV">NV</option>
           <option value="NY">NY</option>
           <option value="OH">OH</option>
           <option value="OK">OK</option>
           <option value="OR">OR</option>
           <option value="PA">PA</option>
           <option value="PR">PR</option>
           <option value="RI">RI</option>
           <option value="SC">SC</option>
           <option value="SD">SD</option>
           <option value="TN">TN</option>
           <option value="TX">TX</option>
           <option value="UT">UT</option>
           <option value="VA">VA</option>
           <option value="VT">VT</option>
           <option value="WA">WA</option>
           <option value="WI">WI</option>
           <option value="WV">WV</option>
           <option value="WY">WY</option>
          </select>
         </div>
        </div>
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">Zip</label>
          <input type="text" class="form-control" name="company_zip" value="06443" />
         </div>
        </div>
       </div>
       <div class="row">
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">Phone</label>
          <input type="text" class="form-control" name="company_phone_1" value="2034417938" />
         </div>
        </div>
        <div class="col-sm">
         <div class="mb-3">
          <label for="" class="d-block">Phone <small>(alternate)</small></label>
          <input type="text" class="form-control" name="company_phone_2" value="8883155797" />
         </div>
        </div>
       </div>
       <h5 class="text-gold">Website Settings</h5>
       <div class="row">
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Email Address</label>
          <input type="text" class="form-control" name="company_email" value="contact@earlyaccesscare.com" />
         </div>
        </div>
        <div class="col-md">
         <div class="mb-3">
          <label for="" class="d-block">Website URL</label>
          <input type="text" class="form-control" name="company_url" value="" />
         </div>
        </div>
       </div>
       <div class="mb-3">
        <label for="" class="d-block">Company Logo <small>({{config('eac.storage.file.type')}})</small></label>
        <div class="input-group">
         <input type="file" class="form-control" name="company_logo" value="" />
        </div>
        <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
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
