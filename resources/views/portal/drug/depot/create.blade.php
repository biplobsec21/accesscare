@extends('layouts.portal')
<style>
  .label_required:after { 
   content:"*";
   color:red;
}
</style>
@section('title')
  Create Depot
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{route('eac.portal.depot.list.all')}}">All Depots</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
     @yield('title')
    </li>
   </ol>
  </nav>
  <h2 class="m-0">
   @yield('title')
  </h2>
 </div><!-- end .titleBar -->

  <form method="post" action="{{ route('eac.portal.depot.store') }}">
    {{ csrf_field() }}
    <input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
  <div class="actionBar">
   <a href="{{ url()->previous() }}" class="btn btn-light">
    <i class="far fa-angle-double-left"></i> Go back
   </a>
  </div><!-- end .actionBar -->
  
  <div class="viewData">
   <div class="row">
    <div class="col-lg-4 col-xl order-lg-2">
     <div class="instructions mb-3">
      Instructions
     </div>
    </div>
    <div class="col-lg-8 col-xl-7 order-lg-1">
     <div class="card card-body">
      <h5 class="text-gold mb-2 mb-xl-4">
       Depot Information
      </h5>
      <div class="mb-3">
       <label class="d-block label_required">Depot Name</label>
       <input type="text" name="depot_name" placeholder="Depot Name" class="form-control" required="required">
      </div>
      <div class="mb-3">
       <label class="d-block label_required">Street Address</label>
       <input type="text" name="depot_addr1" placeholder="Address Line 1" class="form-control mb-1" required="required">
       <input type="text" name="depot_addr2" placeholder="Address Line 2" class="form-control">
      </div>
      <div class="row">
       <div class="col-sm col-md-8 col-lg-12 col-xl-7 mb-3">
        <label class="d-block label_required">Country</label>
        <select class="form-control select2 {{ $errors->has('depot_country_id') ? ' is-invalid' : '' }}" id="country_id" name="depot_country_id">
         @foreach($countries as $country)
          <option value="{{$country->id}}" {{old('depot_country_id') == $country->id ? 'selected' : '' }}>{{$country->name}}</option>
         @endforeach
        </select>
        <div class="invalid-feedback">
         {{ $errors->first('depot_country_id') }}
        </div>
       </div>
       <div class="col-sm col-md-4 col-lg-12 col-xl mb-3">
        <label class="d-block label_required"  id="city_lbl">City</label>
        <input type="text"  id="city_input"  class="form-control{{ $errors->has('depot_city') ? ' is-invalid' : '' }}" name="depot_city" value="{{ old('depot_city') }}" placeholder="City">
        <div class="invalid-feedback">
         {{ $errors->first('depot_city') }}
        </div>
       </div>
      </div>
      <div class="row">
       <div class="col-sm col-lg-7 mb-3">
        <label class="d-block"  id="state_lbl">State</label>
        
        <select class=" form-control{{ $errors->has('depot_state_province') ? ' is-invalid' : '' }}" name="depot_state_province" id="state_option">
        <option disabled hidden selected value="">-- Select --</option>
        @foreach($states as $state)
         <option value="{{$state->id}}" {{ old('depot_state_province') == $state->id ? 'selected' : ''}}>{{$state->name}}</option>
        @endforeach
       </select>
       <input type="text" placeholder="Province" name="depot_state_province" id="state_text" class="form-control" value="{{ old('depot_state_province')}}">
        <div class="invalid-feedback">
         {{ $errors->first('depot_state_province') }}
        </div>
       </div>
       <div class="col-sm col-lg-5 mb-3">
        <label class="d-block label_required" id="zip_lbl">Postal Code</label>
        <input type="text" id="zip_input" class="form-control{{ $errors->has('depot_zip') ? ' is-invalid' : '' }}" name="depot_zip" value="{{ old('depot_zip') }}" placeholder="Postal Code">
        <div class="invalid-feedback">
         {{ $errors->first('depot_zip') }}
        </div>
       </div>
      </div>

      <div class="row">
       <div class="ml-auto mr-auto col-sm-10 col-md-8 col-lg-6">
        <button class="btn btn-success btn-block" type="submit">
         <i class="far fa-check"></i> Save Depot
        </button>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div><!-- /.viewData -->
  </form>
@endsection

@section('scripts')
<script>
  $(document).ready(function () {
     $('.select2').select2();
      $( "#state_text" ).hide();
      $('#state_text').attr("disabled", true);
      $("#state").prop('required',false);
      $("#country_id").on('change',function(){
        countrySelected();

      });
      countrySelected();
  });
 function countrySelected(){
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
          $("#zip_lbl").text('Postal Code');
          $("#zip_input").attr('placeholder','Postal Code');
          $("#state_lbl").text('State');
        }
   }

</script>
@endsection


