@extends('layouts.portal')

@section('styles')
 <style>
  @media screen and (min-width: 1200px) {
   :root {
    --leftCol: 230px;
    --rightCol: 675px;
   }

   .actionBar, .instructions {
    max-width: calc(var(--leftCol) + var(--rightCol));
   }

   .viewData .row.thisone > [class*=col]:first-child {
    width: var(--leftCol);
   }

   .viewData .row.thisone > [class*=col]:last-child {
    width: var(--rightCol);
   }
  }
  @media screen and (min-width: 1300px) {
   :root {
    --rightCol: 790px;
   }
  }
 </style>
@endsection

@section('instructions')
 instructions
@endsection

@section('title')
  Create Pharmacy
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{route('eac.portal.pharmacy.list.all')}}">All Pharmacies</a>
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

 <form method="post" action="{{ route('eac.portal.pharmacy.store') }}">
  {{ csrf_field() }}
  <input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
  <div class="actionBar">
   <a href="{{ route('eac.portal.pharmacy.list.all') }}" class="btn btn-light">
    Pharmacy List
   </a>
  </div><!-- end .actionBar -->
  <div class="viewData">
   <div class="instructions mb-3">
    @yield('instructions')
   </div>
   <div class="row thisone m-0 mb-xl-5">
    <div class="col-sm-3 col-xl-auto p-0 pr-sm-2 mb-2 mb-sm-0">
     <div class="wizardSteps symbols nav flex-row flex-sm-column" id="tab" role="tablist" aria-orientation="vertical">
      <a class="nav-link active" id="xdetails-tab" data-toggle="pill" href="#xdetails" role="tab" aria-controls="xdetails" aria-selected="true">
       <span>Pharmacy Details</span>
      </a>
      {{-- <a class="nav-link" id="two-tab" data-toggle="pill" href="#two" role="tab" aria-controls="two" aria-selected="false">
       <span>Pharmacists</span>
      </a> --}}
     </div>
    </div>
    <div class="col-sm-8 col-lg-7 col-xl-auto p-0 pl-sm-2">
     <div class="card tab-content wizardContent" id="tabContent">
      <div class="tab-pane fade show active" id="xdetails" role="tabpanel" aria-labelledby="xdetails-tab">
       <div class="card-body">
        <h5 class="mb-3">
         Please provide <strong>pharmacy details</strong>
        </h5>
        <div class="mb-3">
         <label class="d-block label_required">Pharmacy Name</label>
         <input type="text" name="pharmacy_name" placeholder="Pharmacy Name" class="form-control{{ $errors->has('pharmacy_name') ? ' is-invalid' : '' }}">
        </div>
        <div class="mb-3">
         <label class="d-block label_required">Street Address</label>
         <input type="text" name="pharmacy_addr1" placeholder="Address Line 1" class="form-control mb-1{{ $errors->has('pharmacy_addr1') ? ' is-invalid' : '' }}">
         <input type="text" name="pharmacy_addr2" placeholder="Address Line 2" class="form-control">
        </div>
       {{--  <div class="row">
         <div class="col-sm col-md-8 col-lg-12 col-xl-7 mb-3">
          <label class="d-block label_required">Country</label>
          <select name="pharmacy_country_id" id="ci" class="form-control{{ $errors->has('pharmacy_country_id') ? ' is-invalid' : '' }}">
           <option disabled hidden selected value="">-- Select --</option>
           @foreach($countries as $country)
            <option value="{{ $country->id }}">{{ $country->name }}</option>
           @endforeach
          </select>
         </div>
         <div class="col-sm col-md-4 col-lg-12 col-xl mb-3">
          <label class="d-block label_required" id="city_lbl">Town/City</label>
          <input type="text" name="pharmacy_city" placeholder="City" class="form-control{{ $errors->has('pharmacy_city') ? ' is-invalid' : '' }}">
         </div>
        </div> --}}
       {{--  <div class="row">
         <div class="col-sm col-lg-7 mb-3">
          <label class="d-block">State</label>
          <select name="pharmacy_state_province" id="pharmacy_state_province" class="form-control">
           <option disabled hidden selected value="">-- Select --</option>
           @foreach($states as $state)
            <option value="{{ $state->id }}">{{ $state->name }}</option>
           @endforeach
          </select>
         </div>
         <div class="col-sm col-lg-5 mb-3">
          <label class="d-block label_required" id="zip_lbl">Postal Code</label>
          <input type="number" name="pharmacy_zip" placeholder="ZIP Code" class="form-control {{ $errors->has('pharmacy_zip') ? ' is-invalid' : '' }}">
         </div>
        </div> --}}

        <div class="row">
         <div class="col-sm col-md-8 col-lg-12 col-xl-7 mb-3">
          <label class="d-block label_required">Country</label>
          <select class="form-control select2 {{ $errors->has('pharmacy_country_id') ? ' is-invalid' : '' }}" id="country_id" name="pharmacy_country_id">
           <option disabled hidden  value="">-- Select --</option>
           @foreach($countries as $country)
            <option value="{{$country->id}}" {{ old('pharmacy_country_id') == $country->id ? 'selected' : ''}}>{{$country->name}}</option>
           @endforeach
          </select>
          <div class="invalid-feedback">
           {{ $errors->first('pharmacy_country_id') }}
          </div>
         </div>
         <div class="col-sm col-md-4 col-lg-12 col-xl mb-3">
          <label class="d-block label_required"  id="city_lbl">City</label>
          <input type="text"  id="city_input"  class="form-control{{ $errors->has('pharmacy_city') ? ' is-invalid' : '' }}" name="pharmacy_city" value="{{ old('pharmacy_city') }}" placeholder="City">
          <div class="invalid-feedback">
           {{ $errors->first('pharmacy_city') }}
          </div>
         </div>
        </div>
        <div class="row">
         <div class="col-sm col-lg-7 mb-3">
          <label class="d-block label_required"  id="state_lbl">State</label>
          
          <select class=" form-control{{ $errors->has('pharmacy_state_province') ? ' is-invalid' : '' }}" name="pharmacy_state_province" id="state_option" value="{{ old('pharmacy_state_province') }}" required="required">
          <option disabled hidden selected value="">-- Select --</option>
          @foreach($states as $state)
           <option value="{{$state->id}}" {{ old('pharmacy_state_province') == $state->id ? 'selected' : ''}}>{{$state->name}}</option>
          @endforeach
         </select>
         <input type="text" placeholder="Province" name="pharmacy_state_province" id="state_text" class="form-control" required="required" value="{{ old('pharmacy_state_province') }}">
          <div class="invalid-feedback">
           {{ $errors->first('province') }}
          </div>
         </div>
         <div class="col-sm col-lg-5 mb-3">
          <label class="d-block label_required" id="zip_lbl">Zip</label>
          <input type="text" id="zip_input" class="form-control{{ $errors->has('pharmacy_zip') ? ' is-invalid' : '' }}" name="pharmacy_zip" value="{{ old('pharmacy_zip') }}" placeholder="Zipcode">
          <div class="invalid-feedback">
           {{ $errors->first('pharmacy_zip') }}
          </div>
         </div>
        </div>
       </div>
       <div class="card-footer d-flex justify-content-between p-2">
        <button class="btn btn-success" type="submit">
         <i class="far fa-check"></i> Save Pharmacy
        </button>
      {{--   <a href="#" class="next btn btn-success">
         Continue <i class="fal fa-angle-double-right"></i>
        </a> --}}
       </div>
      </div><!-- /.tab-pane -->
      <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
       <div class="card-body">
        <h5 class="mb-3">
         Pharmacists
        </h5>
        <div class="table-responsive">
         <table class="table table-sm table-striped table-hover">
          <thead>
           <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th></th>
           </tr>
          </thead>
          <tbody id="">
           <tr>
            <td>
             <input type="text" name="name" placeholder="Pharmacy Name" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
            </td>
            <td>
             <input type="email" name="email" placeholder="Email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
            </td>
            <td>
             <input type="text" name="phone" placeholder="Phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}">
            </td>
            <td>
             <a class="text-danger remove" href="#">
              <i class="fas fa-times"></i>
             </a>
            </td>
           </tr>
          </tbody>
         </table>
        </div>
        <div class="mt-3">
         <a href="#" class="btn btn-link">
          <i class="fal fa-plus"></i> Add Pharmacist
         </a>
        </div>
       </div>
       <div class="card-footer text-right p-2">
        <button class="btn btn-success" type="submit">
         <i class="far fa-check"></i> Save Pharmacy
        </button>
       </div>
      </div><!-- /.tab-pane -->
     </div>
    </div>
   </div><!-- /.row -->
  </div>
 </form>
 
@endsection

@section('scripts')

<script type="text/javascript">
  $(document).ready(function () {
     $('.select2').select2();
      $( "#state_text" ).hide();
      $('#state_text').attr("disabled", true);
      $("#state").prop('required',false);
      $("#country_id").on('change',function(){
        countryselected();
      });
      countryselected();
  });
  $(function () {
   $("a.next").click(function () {
    let currentLink = $('.nav-link.active');
    setWizardStep(currentLink.index() + 1);
   });

   $("a.prev").click(function () {
    let currentLink = $('.nav-link.active');
    setWizardStep(currentLink.index() - 1);
   });

   let jumped = false;

   $(".tab-pane").each(function () {
    let errorCount = $(this).find('.is-invalid').length;
    if (errorCount > 0) {
     let link = $('a[aria-controls=' + $(this).attr('id') + ']');
     link.addClass('invalid');
     if (!jumped) {
      setWizardStep(link.index());
      jumped = true;
     }
    }
   });

   function setWizardStep(n) {
    $('.wizardSteps a.nav-link:nth-child(' + (n + 1) + ')').click();
   }
  });
 
 function countryselected(){
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
 }
</script>
@endsection
