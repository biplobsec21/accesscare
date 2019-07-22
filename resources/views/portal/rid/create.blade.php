@extends('layouts.portal')

@section('title')
	Initiating Request for Investigational Drug (RID)
@endsection

@section('styles')
	<style>
		@media screen and (min-width: 1200px) {
			.viewData .row[class*=justify-content] > [class*=col]:last-child {
				width: 550px;
			}

			.viewData .instructions {
				max-width: 750px;
			}
		}

		.neg-margin {
			display: none !important
		}

		/* Andrew, remove this line of css if you want next and prev buttons on top */
	</style>
@endsection

@section('instructions')
	To make a request for investigational drug, complete required information. Provide the diagnosis and further relevant information, such as failure of all available treatments. Provide brief description of proposed treatment regimen, if available.
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.rid.list') }}">All RIDs</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					@yield('title')
				</li>
			</ol>
		</nav>
		<h5 class="m-0">
			@yield('title')
		</h5>
	</div><!-- end .titleBar -->

	<form method="post" action="{{ route('eac.portal.rid.review') }}">
		{{ csrf_field() }}
		<div class="actionBar">
			<a href="{{ url()->previous() }}" class="btn btn-light">
				<i class="far fa-angle-double-left"></i> Go back
			</a>
		</div><!-- end .actionBar -->

		<div class="viewData">
			<div class="instructions mb-3">
				@yield('instructions')
			</div>
			<div class="row justify-content-center justify-content-xl-start m-0">
				<div class="col-sm-auto p-0 pr-sm-2 mb-2 mb-sm-0 ">
					<div class="wizardSteps nav flex-row flex-sm-column justify-content-center justify-content-sm-start"
					     id="tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="one-tab" data-toggle="pill" href="#one" role="tab"
						   aria-controls="one" aria-selected="false">
							<span>Assign Request</span>
						</a>
						<a class="nav-link" id="two-tab" data-toggle="pill" href="#two" role="tab" aria-controls="two"
						   aria-selected="false">
							<span>Patient Information</span>
						</a>
						<a class="nav-link" id="three-tab" data-toggle="pill" href="#three" role="tab"
						   aria-controls="three" aria-selected="true">
							<span>Drug Selection</span>
						</a>
						<a class="nav-link" id="four-tab" data-toggle="pill" href="#four" role="tab"
						   aria-controls="four" aria-selected="false">
							<span>Delivery Date</span>
						</a>
					</div>
				</div>
				<div class="col-sm-7 col-lg-6 col-xl-auto p-0 pl-sm-2">
					<div class="card h-100">
						<div class="tab-content wizardContent" id="tabContent">
							<!-- first tab should only be available (and active) if user is able to select other users, ie: only for EAC -->
							<div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
								<div class="card-body">
									<div class="d-flex justify-content-end neg-margin">
										<a href="#" class="next btn btn-link">
											<i class="fal fa-angle-double-right"></i>
										</a>
									</div>
									<h5 class="mb-3">
										Who should this request be <strong>assigned</strong> to?
									</h5>
									<div class="mb-5">

										@if(\Auth::user()->type->name == 'Early Access Care')
											<select
												class="form-control select2 {{ $errors->has('physician_id') ? ' is-invalid' : '' }}"
												name="physician_id">
												<option value="" hidden></option>
												@foreach(\App\User::physicians() as $physician)
													<option
														value="{{ $physician->id }}" {{ old("physician_id") == $physician->id ? "selected":"" }}>{{ $physician->full_name }}</option>
												@endforeach
											</select>
										@else
											<select class="form-control" name="physician_id">

												<option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->full_name }}</option>
											</select>
										@endif

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
									<div class="d-flex justify-content-between neg-margin">
										<a href="#" class="prev btn btn-link">
											<i class="fal fa-angle-double-left"></i>
										</a>
										<a href="#" class="next btn btn-link">
											<i class="fal fa-angle-double-right"></i>
										</a>
									</div>
									<h5 class="mb-3">
										Please provide <strong>patient information</strong>
									</h5>
									<div class="row mb-3">
										<div class="col col-sm-12 col-md-8 mb-2">
											<label class="d-block">Date of Birth</label>
											<div class="row m-0">
												<div class="col-sm p-0">
													<select
														class="form-control  {{ $errors->has('patient_dob.month') ? ' is-invalid' : '' }}"
														name="patient_dob[month]">
														<option hidden selected value="">Month</option>
														<option value="1"
														        @if(optional(optional(old('patient_dob')))['month'] == "1") selected @endif >
															January
														</option>
														<option value="2"
														        @if(optional(optional(old('patient_dob')))['month'] == "2") selected @endif >
															February
														</option>
														<option value="3"
														        @if(optional(old('patient_dob'))['month'] == "3") selected @endif >
															March
														</option>
														<option value="4"
														        @if(optional(old('patient_dob'))['month'] == "4") selected @endif >
															April
														</option>
														<option value="5"
														        @if(optional(old('patient_dob'))['month'] == "5") selected @endif >
															May
														</option>
														<option value="6"
														        @if(optional(old('patient_dob'))['month'] == "6") selected @endif >
															June
														</option>
														<option value="7"
														        @if(optional(old('patient_dob'))['month'] == "7") selected @endif >
															July
														</option>
														<option value="8"
														        @if(optional(old('patient_dob'))['month'] == "8") selected @endif >
															August
														</option>
														<option value="9"
														        @if(optional(old('patient_dob'))['month'] == "9") selected @endif >
															September
														</option>
														<option value="10"
														        @if(optional(old('patient_dob'))['month'] == "10") selected @endif >
															October
														</option>
														<option value="11"
														        @if(optional(old('patient_dob'))['month'] == "11") selected @endif >
															November
														</option>
														<option value="12"
														        @if(optional(old('patient_dob'))['month'] == "12") selected @endif >
															December
														</option>
													</select>
												</div>
												<div class="col p-0">
													<input type="number"
													       class="form-control border-left-0 border-right-0 p_date {{ $errors->has('patient_dob.day') ? ' is-invalid' : '' }}"
													       name="patient_dob[day]" placeholder="Day"
													       value="{{ optional(old('patient_dob'))['day'] }}"/>
												</div>
												<div class="col p-0">
													<input type="number"
													       class="form-control dob_year {{ $errors->has('patient_dob.year') ? ' is-invalid' : '' }}"
													       name="patient_dob[year]" placeholder="Year"
													       value="{{ optional(old('patient_dob'))['year'] }}"/>
												</div>
											</div>
											<div class="invalid-feedback">
												@if($errors->first('patient_dob.month'))
													{{ $errors->first('patient_dob.month') }}
												@elseif($errors->first('patient_dob.day'))
													{{ $errors->first('patient_dob.day') }}
												@elseif($errors->first('patient_dob.year'))
													{{ $errors->first('patient_dob.year') }}
												@endif
											</div>
											<span id="dob_year_invalid" class="text-danger"></span>
										</div>
										<div class="col-auto col-sm-12 col-md-4 mb-2">
											<label class="d-block">Gender</label>
											<select name="patient_gender"
											        class="form-control{{ $errors->has('patient_gender') ? ' is-invalid' : '' }}">
												<option hidden selected value="">-- Select --</option>
												<option value="1" {{old('patient_gender') == '1' ? 'selected' : ''}}>
													Male
												</option>
												<option value="0" {{old('patient_gender') == '0' ? 'selected' : ''}}>
													Female
												</option>
											</select>
											<div class="invalid-feedback">
												{{ $errors->first('patient_gender') }}
											</div>
										</div>
									</div>
									<div class="mb-5">
										<label class="d-block">Diagnosis and Reason for Compassionate
											Use</label>
										<textarea maxlength="3000" name="reason" rows="5"
										          class="form-control{{ $errors->has('reason') ? ' is-invalid' : '' }}">{!! old('reason') !!}</textarea>
										<div class="invalid-feedback">
											{{ $errors->first('reason') }}
										</div>
									</div>
								</div>
								<div class="card-footer d-flex justify-content-between p-2">
									<a href="#" class="prev btn btn-light">
										<i class="fal fa-angle-double-left"></i> Back
									</a>
									<a href="#" class="next btn btn-success">
										Continue <i class="fal fa-angle-double-right"></i>
									</a>
								</div>
							</div><!-- /.tab-pane -->
							<div class="tab-pane fade" id="three" role="tabpanel" aria-labelledby="three-tab">
								<div class="card-body">
									<div class="d-flex justify-content-between neg-margin">
										<a href="#" class="prev btn btn-link">
											<i class="fal fa-angle-double-left"></i>
										</a>
										<a href="#" class="next btn btn-link">
											<i class="fal fa-angle-double-right"></i>
										</a>
									</div>
									<h5 class="mb-3">
										Which <strong>drug</strong> is being requested?
									</h5>
									<div class="mb-3">
										<select
											class="form-control select2{{ $errors->has('drug_id') ? ' is-invalid' : '' }}"
											name="drug_id">
											<option hidden selected value="">-- Select --</option>
											@foreach($drugs as $drug)
												<option
													value="{{ $drug->id }}" {{ old("drug_id") == $drug->id ? "selected":"" }}>{{ $drug->name }}</option>
											@endforeach
										</select>
										<div class="invalid-feedback">
											{{ $errors->first('drug_id') }}
										</div>
									</div>
									<div class="mb-5">
										<label class="d-block">
											Proposed Treatment Regimen
											<small>(Optional)</small>
										</label>
										<textarea maxlength="3000" name="proposed_treatment_plan"
										          class="form-control {{ $errors->has('proposed_treatment_plan') ? ' is-invalid' : '' }}"
										          rows="5">{{ old('proposed_treatment_plan') }}</textarea>
										<div class="invalid-feedback">
											{{ $errors->first('proposed_treatment_plan') }}
										</div>
									</div>
								</div>
								<div class="card-footer d-flex justify-content-between p-2">
									<a href="#" class="prev btn btn-light">
										<i class="fal fa-angle-double-left"></i> Back
									</a>
									<a href="#" class="next btn btn-success">
										Continue <i class="fal fa-angle-double-right"></i>
									</a>
								</div>
							</div><!-- /.tab-pane -->
							<div class="tab-pane fade" id="four" role="tabpanel" aria-labelledby="four-tab">
								<div class="card-body">
									<div class="d-flex justify-content-between neg-margin">
										<a href="#" class="prev btn btn-link">
											<i class="fal fa-angle-double-left"></i>
										</a>
										<button class="btn btn-link btnSubmit" type="submit">
											<i class="fal fa-angle-double-right"></i>
										</button>
									</div>
									<h5 class="mb-3">
										Select requested <strong>delivery date</strong>
									</h5>
									<div class="mb-5">
										<div class="input-group">
											<div class="input-group-prepend">
												<label for="req_date" class="input-group-text">
													<i class="fas fa-calendar"></i>
												</label>
											</div>
											<input type="text"
											       class="datepicker form-control {{ $errors->has('req_date') ? ' is-invalid' : '' }}"
											       name="req_date" id="req_date" value="{{ old('req_date') }}"/>
											<div class="invalid-feedback">
												{{ $errors->first('req_date') }}
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer d-flex justify-content-between p-2">
									<a href="#" class="prev btn btn-light">
										<i class="fal fa-angle-double-left"></i> Back
									</a>
									<button class="btn btn-success btnSubmit" type="submit">
										Initiate Request <i class="fal fa-angle-double-right"></i>
									</button>
								</div>
							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
					</div><!-- /.card -->
				</div>
			</div><!-- /.row -->
		</div><!-- /.viewData -->
	</form>
@endsection
@section('scripts')
	<script>
        $('.select2').select2();

        function phoneValidate(event) {
            var regex = new RegExp("^[0-9-!@#$%*?.()+]");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            } else {
                return true;
            }
        }

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
            };

            $('#dob_year_invalid').text("");
            var current_year = new Date().getFullYear();
            // console.log(current_year);

            $(".p_date").keyup(function () {
                var month = $(".p_date").val().length;
                if (month != 2) {

                    $("#dob_year_invalid").text("Date must have 2 digit!");

                } else {

                    if (parseInt($(".p_date").val()) < parseInt(1)) {
                        $("#dob_year_invalid").text("Date is not allowed");
                        return false;
                    }

                    if (parseInt($(".p_date").val()) > parseInt(31)) {
                        $("#dob_year_invalid").text("Date is not allowed");
                        return false;
                    }

                    $('#dob_year_invalid').text("");

                }

            });
            $(".dob_year").keyup(function () {
                $("#dob_year_invalid").text("Year must have 4 digit!");
                var year_length = $(".dob_year").val().length;

                if (year_length != 4) {

                    $("#dob_year_invalid").text("Year must have 4 digit!");
                } else {

                    if (parseInt($(".dob_year").val()) < parseInt(1910)) {
                        $("#dob_year_invalid").text("Year is not allowed");
                        return false;
                    }

                    if (parseInt($(".dob_year").val()) > parseInt(current_year)) {
                        $("#dob_year_invalid").text("Year is not allowed");
                        return false;
                    }

                    $('#dob_year_invalid').text("");

                }
            });

            $("#pharmacySelect").click(function () {
                if ($(this).val() == 'new') {
                    document.getElementById("newPharmacy").scrollIntoView()
                }
            });

            if ($('#pharmacySelect').val() == 'new') {
                $('#newPharmacy').addClass('show');
                $('#oldPharmacy').removeClass('show');
            } else if ($('#pharmacySelect').val()) {
                $.ajax({
                    type: "POST",
                    url: "{{ route( 'eac.portal.pharmacy.info' ) }}",
                    data: {
                        'pharmacy_id': $('#pharmacySelect').val(),
                    },
                    success: function (response) {
                        $('#pharmaInfo').html(response);
                    },
                });
            }
            $('#pharmacySelect').change(function () {
                if ($(this).val() == 'new') {
                    $('#newPharmacy').addClass('show');
                    $('#oldPharmacy').removeClass('show');
                } else {
                    $('#newPharmacy').removeClass('show');
                    $('#oldPharmacy').addClass('show');
                    $.ajax({
                        type: "POST",
                        url: "{{ route( 'eac.portal.pharmacy.info' ) }}",
                        data: {
                            'pharmacy_id': $(this).val(),
                        },
                        success: function (response) {
                            $('#pharmaInfo').html(response);
                        },
                    });
                }
            });

            $('#pharmacist_unknown').change(function () {
                if (this.checked) {
                    $('.pharmacist_info').hide();
                } else {
                    $('.pharmacist_info').show();
                }
            });

            $('#pharmacy_unknown').change(function () {
                if (this.checked) {
                    $('#pharmacy_info').hide();
                } else {
                    $('#pharmacy_info').show();
                }
            });

        });
	</script>
@endsection
