@extends('layouts.portal')

@section('title')
	Create User
@endsection

@section('styles')
	<style>
  @media screen and (min-width: 1200px) {
   :root {
    --leftCol: 220px;
    --rightCol: 700px;
   }   
   .actionBar, .viewData {
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

{{-- @section('instructions')
 <div class="instructions mb-3">
 	instructions here
 </div>
@endsection --}}

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.user.list') }}">All Users</a>
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
	<form name="" action="{{ route('eac.portal.user.create') }}" method="post">
		{{ csrf_field() }}
		<div class="actionBar">
			<a href="{{ route('eac.portal.user.list') }}" class="btn btn-light">
				User List
			</a>
   <a href="{{ route('eac.portal.user.list') }}" class="ml-xl-auto btn btn-warning">
    <i class="fal fa-times"></i>
    Cancel
   </a>{{-- added per request RP --}}
  </div><!-- end .actionBar -->
		
		<div class="viewData">
				@yield('instructions')
   <div class="row thisone m-0 mb-xl-5">
    <div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
     <div class="wizardSteps nav flex-row flex-sm-column" id="tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="one-tab" data-toggle="pill" href="#one" role="tab" aria-controls="one" aria-selected="true">
							<span>User Details</span>
						</a>
						<a class="nav-link" id="two-tab" data-toggle="pill" href="#two" role="tab" aria-controls="two" aria-selected="false">
							<span>User Address</span>
						</a>
						<a class="nav-link" id="three-tab" data-toggle="pill" href="#three" role="tab" aria-controls="three" aria-selected="true">
							<span>Contact Information</span>
						</a>
					</div>
				</div>
    <div class="col-sm-9 col-xl p-0">
     <div class="card tab-content wizardContent">
						<div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
							<div class="card-body">
								<h5 class="mb-3">
									Please provide
									<strong>user information</strong>
								</h5>
        <div class="mb-3">
         <div class="row">
          <div class="col-auto">
           <label class="d-block">Title</label>
           <select class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title">
            <option disabled hidden selected value="">-- Select --</option>
            @foreach(config('eac.user.availableTitle') as $k => $v)
             <option value="{{$k}}" {{ old('title') == $k ? 'selected' : '' }}>{{$v}}</option>
            @endforeach
           </select>
          </div>
          <div class="col">
           <label class="d-block label_required">First Name</label>
           <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" placeholder="First Name"/>
           <div class="invalid-feedback">
            {{ $errors->first('first_name') }}
           </div>
          </div>
          <div class="col">
           <label class="d-block label_required">Last Name</label>
           <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name"/>
           <div class="invalid-feedback">
            {{ $errors->first('last_name') }}
           </div>
          </div>
         </div>
        </div>
        <div class="mb-3">
         <div class="row">
          <div class="col">
           <label class="d-block label_required">Type of User</label>
           <select class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type">
            <option disabled hidden selected value="">-- Select --</option>
            @foreach($user_types as $type)
             <option value="{{$type->id}}" {{ old('type') == $type->id ? 'selected' : '' }}>
              {{$type->name}}
             </option>
            @endforeach
           </select>
           <div class="invalid-feedback">
            {{ $errors->first('type') }}
           </div>
          </div>
          <div class="col-auto">
           <label class="d-block">Delegate User?</label>
           <input data-field="active" type="checkbox" data-toggle="toggle" data-off="No" data-on="Yes" data-onstyle="success" data-offstyle="secondary" data-width="100" name="is_delegate" value="1" />
          </div>
         </div>
        </div>
							</div>
							<div class="card-footer d-flex justify-content-end p-2">
								<a href="#" class="next btn btn-success">
									Continue
									<i class="fal fa-angle-double-right"></i>
								</a>
							</div>
						</div><!-- /.tab-pane -->
						<div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
							<div class="card-body">
								<h5 class="mb-3">
									Please provide
									<strong> address details</strong>
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
										<label class="d-block">Country</label>
										<select class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" id="country_id" name="country">
											<option value="">-- Select --</option>
											@foreach($countries as $country)
												<option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
											@endforeach
										</select>
										@if($errors->has('phone_country'))
											<div class="invalid-feedback">
												{{ $errors->first('phone_country') }}
											</div>
										@endif
									</div>
									<div class="col-sm col-md-4 col-lg-12 col-xl mb-3">
										<label class="d-block" id="city_lbl">City</label>
										<input type="text" id="city_input" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}" placeholder="City">
										<div class="invalid-feedback">
											{{ $errors->first('city') }}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm col-lg-7 mb-3">
										<label class="d-block" id="state_lbl">State</label>
										<select class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" id="state_option">
											<option disabled hidden selected value="">-- Select --</option>
											@foreach(\App\State::all(['id', 'name'])->sortBy('name') as $state)
												<option value="{{ $state->id }}" {{ old('state') ==  $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
											@endforeach
										</select>
										<input type="text" placeholder="Province" name="state" id="state_text" class="form-control" value="{{ old('state') }}">
										<div class="invalid-feedback">
											{{ $errors->first('state') }}
										</div>
									</div>
									<div class="col-sm col-lg-5 mb-3">
										<label class="d-block" id="zip_lbl">Postal Code</label>
										<input type="text" id="zip_input" class="form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" name="zipcode" value="{{ old('zipcode') }}" placeholder="Postal Code">
										<div class="invalid-feedback">
											{{ $errors->first('zipcode') }}
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer d-flex justify-content-between p-2">
								<a href="#" class="prev btn btn-light">
									<i class="fal fa-angle-double-left"></i>
									Back
								</a>
								<a href="#" class="next btn btn-success">
									Continue
									<i class="fal fa-angle-double-right"></i>
								</a>
							</div>
						</div><!-- /.tab-pane -->
						<div class="tab-pane fade" id="three" role="tabpanel" aria-labelledby="three-tab">
							<div class="card-body">
								<h5 class="mb-3">
									User
									<strong>Contact</strong>
									information
								</h5>
								<div class="row">
									<div class="col-sm mb-3">
										<label class="d-block">Phone Number</label>
										<input type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" placeholder="Phone">
										<div class="invalid-feedback">
											{{ $errors->first('phone') }}
										</div>
									</div>
									<div class="col-sm mb-3">
										<label class="d-block">Email Address</label>
										<input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email">
										<div class="invalid-feedback">
											{{ $errors->first('email') }}
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer d-flex justify-content-between p-2">
								<a href="#" class="prev btn btn-light">
									<i class="fal fa-angle-double-left"></i>
									Back
								</a>
								
								<button class="btn btn-success btnSubmit" type="submit">
									Save
									<i class="fal fa-angle-double-right"></i>
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
	<script>
        $(document).ready(function () {
            $("#state_text").hide();
            $('#state_text').attr("disabled", true);
            $("#state").prop('required', false);
            $("#country_id").on('change', function () {
                if ($("#country_id option:selected").text() != 'United States') {
                    $("#zip_lbl").text('Postal Code');
                    $("#zip_input").attr('placeholder', 'Postal Code');
                    $("#city_lbl").text('Town/City');
                    $("#city_input").attr('placeholder', 'Town/City');
                    $("#state_lbl").text('Province');
                    $("#state_option").hide();
                    $('#state_option').attr("disabled", true);
                    $("#state_text").show();
                    $('#state_text').attr("disabled", false);

                } else {
                    $("#state_text").hide();
                    $('#state_text').attr("disabled", true);
                    $("#state_option").show();
                    $('#state_option').attr("disabled", false);
                    $("#state_lbl").text('State');
                    $("#city_lbl").text('City');
                    $("#city_input").attr('placeholder', 'City');
                    $("#zip_lbl").text('Postal Code');
                    $("#zip_input").attr('placeholder', 'Postal Code');
                }

            });
            if ($("#country_id option:selected").text() != 'United States') {
                $("#zip_lbl").text('Postal Code');
                $("#zip_input").attr('placeholder', 'Postal Code');
                $("#city_lbl").text('Town/City');
                $("#city_input").attr('placeholder', 'Town/City');
                $("#state_lbl").text('Province');
                $("#state_option").hide();
                $('#state_option').attr("disabled", true);
                $("#state_text").show();
                $('#state_text').attr("disabled", false);

            } else {
                $("#state_text").hide();
                $('#state_text').attr("disabled", true);
                $("#state_option").show();
                $('#state_option').attr("disabled", false);
                $("#state_lbl").text('State');
                $("#city_lbl").text('City');
                $("#city_input").attr('placeholder', 'City');
                $("#zip_lbl").text('Postal Code');
                $("#zip_input").attr('placeholder', 'Postal Code');
            }
            if ($('#country_id').val() == '') {
                $("#state_lbl").text('State');
            }
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
	</script>
@endsection






