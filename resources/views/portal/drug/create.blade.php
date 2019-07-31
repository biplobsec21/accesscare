@extends('layouts.portal')

@section('title')
	Add New Drug
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
	</style>
@endsection

@section('instructions')
	When adding or editing a drug you are required to have at least 1 active dosage and at least 1 required drug specific documentation.
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.drug.list') }}">All Drugs</a>
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
	<div class="actionBar">
		<a href="{{ route('eac.portal.drug.list') }}" class="btn btn-light">
			Drug List
		</a>
	</div><!-- end .actionBar -->
	<form method="post" action="{{ route('eac.portal.drug.store') }}" enctype="multipart/form-data">
		@csrf
		<div class="viewData">
			<div class="instructions mb-3">
				@yield('instructions')
			</div>
			<div class="row justify-content-center justify-content-xl-start m-0">
				<div class="col-sm-auto p-0 pr-sm-2 mb-2 mb-sm-0 ">
					<div class="wizardSteps nav flex-row flex-sm-column justify-content-center justify-content-sm-start" id="tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="one-tab" data-toggle="pill" href="#one" role="tab" aria-controls="one" aria-selected="false">
							<span>Drug Details</span>
						</a>
						<a class="nav-link" id="five-tab" data-toggle="pill" href="#five" role="tab" aria-controls="five" aria-selected="true">
							<span>Availability</span>
						</a>
						<a class="nav-link" id="six-tab" data-toggle="pill" href="#six" role="tab" aria-controls="six" aria-selected="true">
							<span>Website Description</span>
						</a>
						<a class="nav-link" id="two-tab" data-toggle="pill" href="#two" role="tab" aria-controls="two" aria-selected="true">
							<span>Components & Dosages</span>
						</a>
						{{-- <a class="nav-link" id="three-tab" data-toggle="pill" href="#three" role="tab"
						   aria-controls="three" aria-selected="true">
						 <span>Available Dosages</span>
						</a> --}}
					</div>
				</div>
				<div class="col-sm-7 col-lg-6 col-xl-auto p-0 pl-sm-2">
					<div class="card h-100 tab-content wizardContent" id="tabContent">
						<div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
							<div class="card-body">
								<div class="d-flex justify-content-end neg-margin">
									<a href="#" class="next btn btn-link">
										<i class="fal fa-angle-double-right"></i>
									</a>
								</div>
								<h5 class="mb-3">
									Please enter
									<strong>drug details</strong>
								</h5>
								<div class="row">
									<div class="col-md mb-3">
										<label class="d-block label_required">Public Label</label>
										<input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="Drug Name">
										<div class="invalid-feedback">
											{{ $errors->first('name') }}
										</div>
									</div>
									<div class="col-md mb-3">
										<label class="d-block label_required">Lab Name</label>
										<input type="text" name="lab_name" class="form-control{{ $errors->has('lab_name') ? ' is-invalid' : '' }}" value="{{ old('lab_name') }}" placeholder="Drug Lab Name">
										<div class="invalid-feedback">
											{{ $errors->first('lab_name') }}
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label class="d-block label_required">
										Manufactured By
									</label>
									<select class="form-control select2{{ $errors->has('company_id') ? ' is-invalid' : '' }}" name="company_id">
										@if(Auth::user()->company_id)
											<option value="{{ Auth::user()->company->id }}" {{ old('company_id') && old('company_id') ==  $company->id ? 'selected' : ''}}>{{ Auth::user()->company->name }}</option>
										@else
											@if($companies->count() > 0)
												<option value="">-Select-</option>
												@foreach($companies as $company)
													<option value="{{ $company->id }}" {{ old('company_id') && old('company_id') ==  $company->id ? 'selected' : ''}}>{{ $company->name }}</option>
												@endforeach
											@endif
										@endif
									</select>
									<div class="invalid-feedback">
										{{ $errors->first('company_id') }}
									</div>
								</div>
								
								<div class="mb-3">
									<label class="d-block label_required">Internal Description</label>
									<textarea maxlength="3000" name="desc" class="form-control{{ $errors->has('desc') ? ' is-invalid' : '' }}" rows="5">{{ old('desc') }}</textarea>
									<div class="invalid-feedback">
										{{ $errors->first('desc') }}
									</div>
								</div>
								
								<div class="row">
									<div class="col-md mb-3">
										<label class="d-block">Drug image <small>({{config('eac.storage.file.type')}})</small></label>
          <div class="input-group mb-0">
 										<input type="file" name="drug_image" class="form-control{{ $errors->has('drug_image') ? ' is-invalid' : '' }}">
          </div>
          <div class="d-flex justify-content-between flex-wrap">
           <div>
            <div class="invalid-feedback">
             {{ $errors->first('drug_image') }}
            </div>
           </div>
           <div>
            <label class="d-block small">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
           </div>
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
						</div><!-- /.tab-pane <GENERAL> -->
						<div class="tab-pane fade" id="five" role="tabpanel" aria-labelledby="five-tab">
							<div class="card-body">
								<h5 class="mb-3 label_required">
									Drug is available in these
									<strong>countries</strong>
									:
								</h5>
								<div class="mb-3">
									<select name="countries_available[]" class="form-control select2 {{ $errors->has('countries_available') ? ' is-invalid' : '' }}" multiple data-actions-box="true">
										@foreach($countries as $country)
											<option value="{{ $country->id }}" {{ old('countries_available') && in_array($country->id, old('countries_available')) ? 'selected' : ''}}>{{ $country->name }}</option>
										@endforeach
									</select>
									<div class="invalid-feedback">
										{{ $errors->first('countries_available') }}
									</div>
									<label class="h5 mb-0 d-block mt-2" for="hide_countries">
										<input type="checkbox" name="hide_countries" id="hide_countries" value="1" @if(old('hide_countries')) checked @endif />
										Hide Countries on EAC website
									</label>
								</div>
								<div class="mb-3">
									<label class="h5 mb-0 d-block" for="pre_approval_req">
										<input type="checkbox" name="pre_approval_req" id="pre_approval_req" value="1" @if(old('pre_approval_req')) checked @endif />
										Pre-Approval is Required
									</label>
								</div>
								<div class="mb-3">
									<label class="h5 mb-0 d-block" for="ship_without_approval">
										<input type="checkbox" name="ship_without_approval" id="ship_without_approval" value="1" @if(old('ship_without_approval')) checked @endif />
										Ship Without Approval
									</label>
								</div>
								<div class="mb-5">
									<label class="h5 mb-0 d-block" for="allow_remote">
										<input type="checkbox" name="allow_remote" id="allow_remote" value="1" @if(old('allow_remote')) checked @endif />
										Allow Remote Visits
									</label>
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
						</div><!-- /.tab-pane <AVAILABILITY> -->
						<div class="tab-pane fade" id="six" role="tabpanel" aria-labelledby="six-tab">
							<div class="card-body">
								<h5 class="mb-3 label_required">
									Enter publicly facing information on EAC-Company website </h5>
								<textarea class="form-control basic-editor {{ $errors->has('short_desc') ? ' is-invalid' : '' }}" name="short_desc" rows="15">{{ old('short_desc') }}</textarea>
								<div class="invalid-feedback">
									{{ $errors->first('short_desc') }}
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
						<div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
							<div class="card-body">
								<h5 class="mb-3">
									Establish at least 1
									<strong>component</strong>
								</h5>
								<div class="input_fields_wrap mb-3">
									<div class="row ml-0 mb-1 mr-0">
										<div class="col pl-0">
											<input type="text" class="form-control{{ $errors->has('component_main') ? ' is-invalid' : '' }}" name="component_main" placeholder="Component 1" value="{{ old('component_main') ? old('component_main') : 'Component 1' }}"/>
										</div>
										<div class="col-auto pr-0">
											<a href="#" class=" btn btn-success" data-toggle="modal" data-target="#newDosageModal">
												Add Dosages
											</a>
										</div>
									</div>
									<div class="invalid-feedback">
										{{ $errors->first('component_main') }}
									</div>
									@if(Session::get('components'))
										<?php
										$components = Session::get('components');
										for ($i = 0; $i < count($components); $i++) {
										?>
										<div class="input-group">
											<input class="form-control" type="text" placeholder="Component {{$i+2}}" name="component_name[]" value="{{$components[$i]}}"/>
											<a href="#" class="remove_field btn-danger btn">
												<i class="fal fa-minus"></i>
											</a>
										</div>
										<?php
										}
										?>
									@endif
								</div>
								<div class="mb-5">
									<button class="add_field_button btn btn-info btn-sm window-btn">
										<span class="fal fa-plus"></span>
										Add Component
									</button>
								</div>
							</div>
							<div class="card-footer d-flex justify-content-between p-2">
								<a href="#" class="prev btn btn-light">
									<i class="fal fa-angle-double-left"></i>
									Back
								</a>
								<button type="submit" class="btn btn-success">
									Save Drug
									<i class="fal fa-angle-double-right"></i>
								</button>
							
							</div>
						</div><!-- /.tab-pane <COMPONENT> -->
					</div><!-- /.tab-content.card -->
				</div>
			</div><!-- /.row -->
		</div><!-- /.viewData -->
		
		{{--  ******************************* dosage modal ******************************* --}}
		<div class="dosage-modal-wrapper">
			
			<div class="modal fade" id="newDosageModal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header p-2">
							<h5 class="mb-3">
								Enter information on drug component </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<i class="fal fa-times"></i>
							</button>
						</div>
						<div class="modal-body p-3">
							
							<ul class="list-group list-group-flush">
								<li class="list-group-item border-secondary pl-0 pr-0">
									{{--           <strong class="d-block mb-2 text-info">{----COMPONENT 1----}</strong>
									--}}
									<div class="mb-3">
										<label class="d-block label_required">Dosage Form</label>
										<select class="form-control {{ $errors->has('form_id') ? ' is-invalid modalOpen' : '' }}" name="form_id">
											<option disabled="" hidden="" selected="" value="">
												-- Select --
											</option>
											@if($dosageForm->count() > 0)
												@foreach($dosageForm as $val)
													<option value="{{ $val->id }}" {{ old('form_id') == $val->id ? 'selected' : '' }} >{{$val->name}}</option>
												@endforeach
											@endif
										</select>
										<div class="invalid-feedback">{{ $errors->first('form_id') }}</div>
										<label class="h5 mb-0 d-block mt-2" for="active">
											<input type="checkbox" name="active" id="active" {{ old('active') ? 'checked' : '' }} />
											Dosage is Available/Active <!-- changed from 'Status' -->
										</label>
									</div>
									<div class="row m-0 mb-3">
										<div class="col p-0">
											<label class="d-block label_required">Dose Strength</label>
											<input type="number" class="form-control {{ $errors->has('amount') ? ' is-invalid modalOpen' : '' }}" name="amount" step="any" value="{{ old('amount')}}">
											<div class="invalid-feedback">{{ $errors->first('amount') }}</div>
										</div>
										<div class="col p-0">
											<label class="d-block label_required">Unit</label>
											<select class="form-control border-left-0 {{ $errors->has('unit_id') ? ' is-invalid modalOpen' : '' }}" name="unit_id">
												<option disabled="" hidden="" selected="" value="">-- Select --</option>
												@if($dosageUnit->count() > 0)
													@foreach($dosageUnit as $val)
														<option value="{{ $val->id }}" {{ old('unit_id') == $val->id ? 'selected' : '' }} >{{$val->name}}</option>
													@endforeach
												@endif
											</select>
											<div class="invalid-feedback">
												{{ $errors->first('unit_id') }}
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md mb-3">
											<label class="d-block label_required">Relevant Age Group</label>
											<select class="form-control {{ $errors->has('strength_id') ? ' is-invalid modalOpen' : '' }}" name="strength_id">
												<option disabled="" hidden="" selected="" value="">-- Select --</option>
												@if($dosageStrength->count() > 0)
													@foreach($dosageStrength as $val)
														<option value="{{ $val->id }}" {{ old('strength_id') == $val->id ? 'selected' : '' }} >{{$val->name}}</option>
													@endforeach
												@endif
											</select>
											<div class="invalid-feedback">
												{{ $errors->first('strength_id') }}
											</div>
										</div>
										<div class="col-md mb-3">
											<label class="d-block label_required">
												Optimal Temp
												<span class="d-none d-lg-inline">erature</span>
											</label>
											<div class="input-group">
												{{-- <div class="d-flex justify-content-between align-items-center flex-grow-1">
												 <input type="range" class="form-control slider{{ $errors->has('temperature') ? ' is-invalid modalOpen' : '' }}" name="temperature" value="30">
												 <small class="slider_label ml-2 mr-2"></small>
												</div> --}}
												<input type="number" class="form-control {{ $errors->has('temperature') ? ' is-invalid modalOpen' : '' }}" name="temperature" value="{{ old('temperature') }}">
												<div class="input-group-append">
													<span class="input-group-text d-flex flex-column align-items-stretch text-dark">
														<small class="d-flex">
															<input type="radio" name="temp_opt" value="C" checked/>
															C
														</small>
														<small class="d-flex">
															<input type="radio" name="temp_opt" value="F"/>
															F
														</small>
													</span>
												</div>
											</div>
											<div class="invalid-feedback"></div>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="modal-footer p-2 d-flex justify-content-between">
							<button type="button" class="btn btn-secondary cancel" name="cancel" value="cancel" data-dismiss="modal" tabindex="-1">Cancel
							</button>
							<button type="button" class="btn btn-success" data-dismiss="modal">
								Save Dosage
								<!-- <i class="fal fa-angle-double-right"></i> -->
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		{{--  ******************************* dosage modal ******************************* --}}
	
	</form>
@endsection

@section('scripts')
	<script type="text/javascript">
        $(function () {

            let errorCount = $(".tab-pane").find('.is-invalid').length;
            if (errorCount === 0) {
                if ($('.modalOpen').length > 0) {
                    $('#newDosageModal').modal('show');
                }
            }
            
            $('.slider').on('input change', function () {
                $(this).next($('.slider_label')).html(this.value);
            });
            $('.slider_label').each(function () {
                var value = $(this).prev().attr('value');
                $(this).html(value);
            });
            
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
            
            var wrapper = $(".input_fields_wrap"); //Fields wrapper
            var add_button = $(".add_field_button"); //Add button ID
            var modal_wrapper = $(".dosage-modal-wrapper");


            var x = {{Session::get('components') ? count(Session::get('components'))+1 : 1}}; //initlal text box count
            console.log(x);
            $(add_button).click(function (e) { //on add input button click
                e.preventDefault();
                x++; //text box increment
                $(wrapper).append('<div class="input-group mb-0 mt-2"><div class="row ml-0 mb-1 mr-0"><div class="col pl-0"><input type="text" placeholder="Component ' + x + ' " class="form-control" name="component_name[]" value="Component ' + x + '"/></div><div class="col-auto pr-0"><a href="#" class=" btn btn-success" data-toggle="modal" data-target="#newDosageModal' + x + '">Add Dosages</a></div></div><a href="#"  class="remove_field btn-sm btn-danger btn ml-4" data-id="' + x + '"><i class="fal fa-minus"></i></a></div>'); //add input box
                $(modal_wrapper).append('<div class="modal fade" id="newDosageModal' + x + '" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header p-2"><h5 class="mb-3">Create dosages for the <strong>component ' + x + ':</strong></h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fal fa-times"></i></button></div><div class="modal-body p-3"><ul class="list-group list-group-flush"><li class="list-group-item border-secondary pl-0 pr-0"><div class="mb-3"><label class="d-block label_required">Dosage Form</label><select class="form-control" name="form_id' + x + '"><option disabled="" hidden="" selected="" value="">-- Select --</option>@foreach($dosageForm as $val)<option value="{{ $val->id }}" {{ old('form_id') == $val->id ? 'selected' : '' }} >{{$val->name}}</option>@endforeach</select><label class="h5 mb-0 d-block mt-2" for="active"><input type="checkbox" name="active' + x + '" id="active" {{ old('active') ? 'checked' : '' }} /> Dosage is Available/Active</label></div><div class="row m-0 mb-3"><div class="col p-0"><label class="d-block label_required">Dose Strength</label><input type="number" class="form-control" name="amount' + x + '" step="any" value="{{ old('amount')}}"></div><div class="col p-0"><label class="d-block label_required">Unit</label><select class="form-control border-left-0" name="unit_id' + x + '"><option disabled="" hidden="" selected="" value="">-- Select --</option>@foreach($dosageUnit as $val)<option value="{{ $val->id }}" {{ old('unit_id') == $val->id ? 'selected' : '' }} >{{$val->name}}</option>@endforeach</select></div></div><div class="row"><div class="col-md mb-3"><label class="d-block label_required">Relevant Age Group</label><select class="form-control" name="strength_id' + x + '"><option disabled="" hidden="" selected="" value="">-- Select --</option>@foreach($dosageStrength as $val)<option value="{{ $val->id }}" {{ old('strength_id') == $val->id ? 'selected' : '' }} >{{$val->name}}</option>@endforeach</select> </div><div class="col-md mb-3"><label class="d-block label_required">Optimal Temp<span class="d-none d-lg-inline">Temperature</span></label><input type="text" class="form-control" name="temperature' + x + '" value="{{ old('temperature') }}"></div></div></li></ul></div><div class="modal-footer p-2 d-flex justify-content-between"><button type="button" class="btn btn-secondary cancel" name="cancel' + x + '" value="cancel" data-dismiss="modal" tabindex="-1">Cancel</button><button type="button" class="btn btn-success" data-dismiss="modal">Save Dosage</button></div></div></div></div>');
            });

            $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
                e.preventDefault();
                $(this).parent('div').remove();
                var dosageID = $(this).attr('data-id');
                $('#newDosageModal' + dosageID).remove();
                x--;
            })
        });
	</script>
@endsection
