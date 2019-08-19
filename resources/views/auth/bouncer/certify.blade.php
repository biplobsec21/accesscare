@extends('layouts.portal')

@section('title')
	Certification
@endsection

@section('content')

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

	<form method="post" action="{{ route('eac.portal.user.certify.submit') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
		<div class="viewData">
			<div class="row">
				<div class="col-lg-9 col-xl-8">
					<div class="card mb-3 mb-xl-5">
						<div class="card-header">
							<input class="" name="emergency_register" id="emergency_register" type="checkbox" value="1"/>
							<label>Not Available</label>
						</div>
						<div class="card-body">
							<div class="row" id="registration_forms">
								<div class="col-sm mb-3">
									<h5 class="m-0 strong">Curriculum Vitae/Resume</h5>
         <label class="d-block">Please upload your CV or Resume <small>({{config('eac.storage.file.type')}})</small></label>
         <div class="input-group">
          <input type="file" name="cv_file" value="{{ old('cv_file') }}" class="form-control{{ $errors->has('cv_file') ? ' is-invalid' : '' }}">
         </div>
         <div class="d-flex justify-content-between flex-wrap">
          <div>
           <div class="invalid-feedback">
            {{ $errors->first('cv_file') }}
           </div>
          </div>
          <div>
           <label class="d-block small">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
          </div>
         </div>
								</div>
								<div class="col-sm mb-3">
									<h5 class="m-0 strong">Medical License</h5>
          <label class="d-block">Please upload your active medical license <small>({{config('eac.storage.file.type')}})</small></label>
          <div class="input-group">
 										<input type="file" name="license_file" value="{{ old('license_file') }}" class="form-control{{ $errors->has('license_file') ? ' is-invalid' : '' }}">
         </div>
         <div class="d-flex justify-content-between flex-wrap">
          <div>
           <div class="invalid-feedback">
      						{{ $errors->first('license_file') }}
           </div>
          </div>
          <div>
           <label class="d-block small">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
          </div>
         </div>
        </div>
							</div><!-- /.row -->
							<h5 class="m-0 strong">Physician Declaration</h5>
							<p class="mb-2">By acknowledging these statements, I am declaring the following:</p>
							<div class="pre-scrollable" style="max-height: 30vh">
								<ul class="small m-0">
									<li class="mb-1">I am requesting investigational drug in accordance with the laws
										and regulations in my country, for
										the
										patient specified in the request.&nbsp;
									</li>
									<li class="mb-1">I am responsible for the investigational drug, its administration,
										and its proper use.&nbsp;
									</li>
									<li class="mb-1">I will obtain informed consent from the patient or the patient's
										legally acceptable representative
										prior to
										the administration of the first dose in accordance with local laws and
										regulations. The consent will
										include
										authorization to transfer outcome and/or safety data to the pharmaceutical
										company or its
										representatives in
										accordance with local laws and regulations).&nbsp;
									</li>
									<li class="mb-1">I will inform the patient of known risks associated with the
										investigational drug and that it is not
										approved
										in the country of the request.&nbsp;
									</li>
									<li class="mb-1">I will return unused investigational drug as instructed.&nbsp;</li>
									<li class="mb-1">I will report adverse drug reactions and serious adverse drug
										reactions as required using the AE
										Report
										Form.&nbsp;
									</li>
									<li class="mb-1">I will inform the Institutional Review Board and/or Ethics
										Committee regarding the use of the
										investigational
										drug for treatment of your patient, if required by local laws and regulations or
										institutional
										requirements.&nbsp;
									</li>
									<li class="mb-1">I will notify/obtain approval from the regulatory authority
										regarding the use of the investigational
										drug
										for
										treatment of your patient, as required by local laws and regulations.&nbsp;
									</li>
									<li class="mb-1">I am responsible for the maintenance of accurate records regarding
										the specific investigational
										drug.&nbsp;
									</li>
									<li class="mb-1">I will maintain confidentiality of information about the
										investigational drug.&nbsp;
									</li>
									<li class="mb-1">I will inform Early Access Care that investigational drug is no
										longer required.&nbsp;
									</li>
									<li class="mb-1">I will provide a copy of any summaries submitted to local
										health/regulatory authorities.&nbsp;
									</li>
								</ul>
							</div>
						</div>
						<div class="card-footer alert-warning text-dark strong">
							By typing my name into the below box, I certify that I have read all items on the physician
							declaration and agree to its terms.</br>
       I understand that by typing my name this constitutes an electronic signature for the physician declaration.
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-8 col-lg-10">
									<input type="text" name="user_signature" class="form-control {{ $errors->has('user_signature') ? ' is-invalid' : '' }}" value="{{ old('user_signature') }}" placeholder="X">
									<div class="invalid-feedback">
										{{ $errors->first('user_signature') }}
									</div>
								</div>
								<div class="col-md-4 col-lg-2">
									<button class="btn btn-primary btn-block" type="submit">
										Submit
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection

@section('scripts')
	<script>
		$(document).ready(function(){
		 $('#emergency_register').click(function(){
    if($("#emergency_register").is(':checked')){

    swal({
     title: "Registration Not Available",
     text: "Expanded Access / Compassionate Use requests cannot be processed or approved without confirmation of CV/Medical License as required by local laws and regulations.",
     icon: "warning",
     buttons: [
      'Cancel',
      'Proceed with Request'
     ],
     dangerMode: true,
    }).then(function(isConfirm) {
     if (isConfirm) {
      $("#registration_forms").hide();
     } else {
      $("#emergency_register").prop( "checked", false );
      swal("Cancelled", "Request cancelled", "error");
     }
    })
    } else {
     $("#registration_forms").show();
    }
		 });
		});
	</script>
@endsection



