@extends('layouts.portal')

@section('title')
	Create Company
@endsection

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
 </style>
@endsection

@section('instructions')
 instruction
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.company.list') }}">All Companies</a>
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
 @include('include.alerts')
 <form name="" method="POST" action="{{ route('eac.portal.company.create') }}">
  {{ csrf_field() }}
  <div class="actionBar">
   <a href="{{ route('eac.portal.company.list') }}" class="btn btn-light">
    Company List
   </a>
  </div><!-- end .actionBar -->

  <div class="viewData">
   <div class="row thisone m-0 mb-xl-5">
    <div class="col-sm-3 col-xl-auto p-0 pr-sm-2 mb-2 mb-sm-0">
     <div class="wizardSteps nav flex-row flex-sm-column" id="tab" role="tablist" aria-orientation="vertical">
      <a class="nav-link active" id="one-tab" data-toggle="pill" href="#one" role="tab" aria-controls="one" aria-selected="false">
       <span>Company Details</span>
      </a>
      <a class="nav-link" id="two-tab" data-toggle="pill" href="#two" role="tab" aria-controls="two" aria-selected="false">
       <span>Company Address</span>
      </a>
     </div>
    </div>
    <div class="col-sm-8 col-lg-7 col-xl-auto p-0 pl-sm-2">
     <div class="card tab-content wizardContent" id="tabContent">
      <div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
       <div class="card-body">
        <div class="{{-- d-flex --}} justify-content-end neg-margin d-none">
         <a href="#" class="next btn btn-link">
          <i class="fal fa-angle-double-right"></i>
         </a>
        </div>
        <h5 class="mb-3">
         Please provide <strong>company information</strong>
        </h5>
        <div class="row">
         <div class="col-sm mb-3">
          <label class="d-block label_required">Company Name</label>
          <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Name">
          <div class="invalid-feedback">
           {{ $errors->first('name') }}
          </div>
         </div>
         <div class="col-sm-5 mb-3">
          <label class="d-block label_required">Abbr<span class="d-sm-none d-md-inline">eviation</span></label>
          <input type="text" class="form-control{{ $errors->has('abbr') ? ' is-invalid' : '' }}" name="abbr" value="{{ old('abbr') }}" placeholder="Abbreviation">
          <div class="invalid-feedback">
           {{ $errors->first('abbr') }}
          </div>
         </div>
        </div>
        <div class="row">
         <div class="col-lg-12 mb-3">
          <label class="d-block">Website</label>
          <input type="text" class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}" name="website" value="{{ old('website') }}" placeholder="Website">
          <div class="invalid-feedback">
           {{ $errors->first('website') }}
          </div>
         </div>
         <div class="col-sm mb-3">
          <label class="d-block label_required">Phone</label>
          <input type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" placeholder="Phone">
          <div class="invalid-feedback">
           {{ $errors->first('phone') }}
          </div>
         </div>
         <div class="col-sm-5 mb-3">
          <label class="d-block label_required">Email</label>
          <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email">
          <div class="invalid-feedback">
           {{ $errors->first('email') }}
          </div>
         </div>
        </div>
       </div>
       <div class="card-footer d-flex justify-content-end p-2">
        <a href="#" class="next btn btn-success">
         Continue <i class="fal fa-angle-double-right"></i>
        </a>
       </div>
      </div><!-- /.tab-pane -->
      <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
       <div class="card-body">
        <div class="{{-- d-flex --}} justify-content-between neg-margin d-none">
         <a href="#" class="prev btn btn-link">
          <i class="fal fa-angle-double-left"></i>
         </a>
         <a href="#" class="next btn btn-link">
          <i class="fal fa-angle-double-right"></i>
         </a>
        </div>
        <h5 class="mb-3">
         Please provide <strong> address details</strong>
        </h5>
        <div class="mb-3">
         <label class="d-block">Street Address</label>
         <input type="text" class="form-control mb-1{{ $errors->has('addr1') ? ' is-invalid' : '' }}" name="addr1" value="{{ old('addr1') }}" placeholder="Street Address">
         <input type="text" class="form-control{{ $errors->has('addr2') ? ' is-invalid' : '' }}" name="addr2" value="{{ old('addr2') }}" placeholder="Street Address Continued (Building, Suite, Floor, etc)">
         <div class="invalid-feedback">
          {{ $errors->first('addr1') }}
         </div>
        </div>
        <div class="row">
         <div class="col-sm col-md-8 col-lg-12 col-xl-7 mb-3">
          <label class="d-block label_required">Country</label>
          <select class="form-control select2 {{ $errors->has('country') ? ' is-invalid' : '' }}" id="country_id" name="country">
           @foreach($countries as $country)
            <option value="{{$country->id}}" {{old('country') == $country->id ? 'selected' : '' }}>{{$country->name}}</option>
           @endforeach
          </select>
          <div class="invalid-feedback">
           {{ $errors->first('country') }}
          </div>
         </div>
         <div class="col-sm col-md-4 col-lg-12 col-xl mb-3">
          <label class="d-block label_required"  id="city_lbl">City</label>
          <input type="text"  id="city_input"  class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}" placeholder="City">
          <div class="invalid-feedback">
           {{ $errors->first('city') }}
          </div>
         </div>
        </div>
        <div class="row">
         <div class="col-sm col-lg-7 mb-3">
          <label class="d-block"  id="state_lbl">State</label>
          
          <select class=" form-control{{ $errors->has('company_state') ? ' is-invalid' : '' }}" name="company_state" id="state_option">
          <option disabled hidden selected value="">-- Select --</option>
          @foreach($state as $state)
           <option value="{{$state->id}}" {{ old('company_state') == $state->id ? 'selected' : ''}}>{{$state->name}}</option>
          @endforeach
         </select>
         <input type="text" placeholder="Province" name="company_state" id="state_text" class="form-control" value="{{ old('company_state')}}">
          <div class="invalid-feedback">
           {{ $errors->first('province') }}
          </div>
         </div>
         <div class="col-sm col-lg-5 mb-3">
          <label class="d-block label_required" id="zip_lbl">Postal Code</label>
          <input type="text" id="zip_input" class="form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" name="zipcode" value="{{ old('zipcode') }}" placeholder="Postal Code">
          <div class="invalid-feedback">
           {{ $errors->first('zipcode') }}
          </div>
         </div>
        </div>
       </div>
       <div class="card-footer d-flex justify-content-between p-2">
        <a href="#" class="prev btn btn-light">
         <i class="fal fa-angle-double-left"></i> Back
        </a>
        <button class="btn btn-success btnSubmit" type="submit">
         Save  <i class="fal fa-angle-double-right"></i>
        </button>
       </div>
      </div><!-- /.tab-pane -->
     </div>
    </div>
   </div>
  </div><!-- /.viewData -->
  </form>
@endsection

@section('scripts')
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

  $(".alert").delay(4000).slideUp(200, function () {
   $(this).alert('close');
  });
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
