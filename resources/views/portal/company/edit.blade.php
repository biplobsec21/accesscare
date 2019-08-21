@extends('layouts.portal')

@section('title')
	Edit Company
@endsection

@section('styles')
	<style>
		@media screen and (min-width: 1200px) {
			:root {
				--leftCol: 230px;
				--rightCol: 750px;
			}			
			.actionBar, .viewData {
				max-width: calc(var(--leftCol) + var(--rightCol));
			}			
			.viewData .row.thisone > [class*=col]:first-child {
				max-width: var(--leftCol);
				min-width: var(--leftCol);
			}			
			.viewData .row.thisone > [class*=col]:last-child {
				max-width: var(--rightCol);
				min-width: var(--rightCol);
			}
		}
	</style>
@endsection

@php
	$bColor = '';
	if($company->status == 'Approved') {
	 $bColor = 'success';
	} // endif
	if($company->status == 'Not Approved') {
	 $bColor = 'danger';
	} // endif
	if($company->status == 'Pending') {
	 $bColor = 'warning';
	} // endif
@endphp

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<div class="row">
				<div class="col-sm-auto">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.company.list') }}">All Companies</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.company.show', $company->id) }}">{{ $company->name }}</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							@yield('title')
						</li>
					</ol>
				</div>
				<div class="d-none d-sm-block col-sm-auto ml-sm-auto">
					<div class="small">
						@if(!is_null($company->updated_at))
							<strong>Last Updated:</strong>
							@php
								$time = $company->updated_at;
								echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
							@endphp
						@endif
					</div>
				</div>
			</div>
		</nav>
		<h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{ $company->name }} <small>({{ $company->abbr }})</small>
		</h2>
		<div class="small d-sm-none">
			@if(!is_null($company->updated_at))
				<strong>Last Updated:</strong>
				@php
					$time = $company->updated_at;					
					echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
				@endphp
			@endif
		</div>
	</div><!-- end .titleBar -->
	
	<div class="viewData">
		<form name="" method="POST" action="{{ route('eac.portal.company.update') }}">
			{{ csrf_field() }}
			@include('include.alerts')
			<div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
				<a href="{{ route('eac.portal.company.show', $company->id) }}" class="btn btn-secondary">
					View Company
				</a>
				<div>
					@if($company->status == 'Approved')
						<a href="{{ route('eac.portal.company.suspend', $company->id) }}" class="btn btn-danger">
							<i class="fal fa-ban"></i> Suspend Company
						</a>
					@elseif($company->status == 'Pending')
						<a href="{{ route('eac.portal.company.approve', $company->id) }}" class="btn btn-success">
							<i class="fal fa-check"></i> Approve Company
						</a>
					@elseif($company->status == 'Not Approved')
						<a href="{{ route('eac.portal.company.reactivate', $company->id) }}" class="btn btn-success">
							<i class="fas fa-redo"></i> Reactivate Company
						</a>
					@endif
				</div>
			</div>
		</form>
		<div class="row thisone m-0 mb-xl-5">
			<div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
				<div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link complete active" id="xdetails-tab" data-toggle="pill" href="#xdetails" role="tab" aria-controls="xdetails" aria-selected="true">
						<span>Company Details</span>
					</a>
					<a class="nav-link @if($company->desc) complete @endif" id="xwebdesc-tab" data-toggle="pill" href="#xwebdesc" role="tab" aria-controls="xwebdesc" aria-selected="false">
						<span>Website Description</span>
					</a>
					<a class="nav-link @if($company->departments->count() > 0) complete @endif" id="xcontacts-tab" data-toggle="pill" href="#xcontacts" role="tab" aria-controls="xcontacts" aria-selected="false">
						<span>Departments</span>
					</a>
					<a class="nav-link @if($company->users->count() > 0) complete @endif" id="xusers-tab" data-toggle="pill" href="#xusers" role="tab" aria-controls="xusers" aria-selected="false">
						<span>Assigned Users</span>
					</a>
				</div>
			</div>
			<div class="col-sm-9 col-xl p-0">
				<div class="card tab-content wizardContent" id="tabContent">
					<div class="alert-light text-dark pt-3 pl-3 pr-3">
						<div class="row">
							<div class="col col-xl-auto mb-3">
								<strong>{{$company->name}}</strong> ({{$company->abbr}})
								<span class="badge badge-{{$bColor}}">{{ $company->status }}</span>
								<ul class="nav flex-row m-0">
									@if($company->site)
										<li class="nav-item">
											<a href="http://{{$company->site}}" target="_blank" class="small" data-toggle="tooltip" data-placement="bottom" title="View Website: {{$company->site}}">
												<i class="text-secondary fa-fw fas fa-external-link-alt fa-sm"></i>
											</a>
										</li>
										<li class="nav-item pl-2 pr-2 d-none d-sm-block text-secondary">|</li>
									@endif
									@if($company->phone_main)
										<li class="nav-item">
											<a href="tel:{{$company->phone->number}}" class="small" data-toggle="tooltip" data-placement="bottom" title="Call {{$company->phone->number}}">
												<i class="text-secondary fa-fw fas fa-phone fa-rotate-90 fa-sm"></i>
											</a>
										</li>
									@endif
									@if(($company->phone_main) && ($company->email_main))
										<li class="nav-item pl-2 pr-2 d-none d-sm-block text-secondary">|</li>
									@endif
									@if($company->email_main)
										<li class="nav-item">
											<a target="_blank" href="mailto:{{$company->email_main}}" class="small" data-toggle="tooltip" data-placement="bottom" title="Email {{$company->email_main}}">
												<i class="text-secondary fa-fw fas fa-envelope fa-sm"></i>
											</a>
										</li>
									@endif
								</ul>
							</div>
							<div class="order-3 order-md-2 col-md col-xl-auto ml-xl-auto mr-xl-auto mb-3">
								@if(isset($company->address))
									<div class="small">
										{{ $company->address->addr1 }}{{$company->address->addr2 ? ', ' . $company->address->addr2 : "" }}<br/>
										{{ $company->address->city }},
										@if($company->address->state){{  $company->address->state->abbr }}@endif {{ $company->address->zipcode }}, {{ $company->address->country->name }}
									</div>
								@endif
							</div>
							<div class="order-2 order-md-3 col-auto mb-3">
								<small class="upper d-block">Created On</small>
								<strong>{{date('Y-m-d', strtotime($company->created_at))}}</strong>
							</div>
						</div>
					</div>
					<div class="tab-pane fade show active" id="xdetails" role="tabpanel" aria-labelledby="xdetails-tab">
						<form name="" method="POST" action="{{ route('eac.portal.company.update') }}">
							{{ csrf_field() }}
							<div class="card-body">
								<div class="row">
									<div class="col-sm mb-3">
										<label class="d-block label_required">Company Name</label>
										<input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $company->name }}" placeholder="Name">
										<div class="invalid-feedback">
											{{ $errors->first('name') }}
										</div>
									</div>
									<div class="col-sm-5 mb-3">
										<label class="d-block label_required">Abbr</label>
										<input type="text" class="form-control{{ $errors->has('abbr') ? ' is-invalid' : '' }}" name="abbr" value="{{ $company->abbr }}" placeholder="Abbreviation">
										<div class="invalid-feedback">
											{{ $errors->first('abbr') }}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 mb-3">
										<label class="d-block">Website</label>
										<input type="text" class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}" name="website" value="{{ $company->site ? $company->site : '' }}" placeholder="Website">
										<div class="invalid-feedback">
											{{ $errors->first('website') }}
										</div>
									</div>
									<div class="col-sm mb-3">
										<label class="d-block">Phone</label>
										<input type="text" class="form-control" name="phone_main" @if($company->phone_main) value="{{ $company->phone->number }}" @endif>
									</div>
									<div class="col-sm mb-3">
										<label class="d-block">Email</label>
										<input type="text" class="form-control" name="email_main" @if($company->email_main) value="{{ $company->email_main }}" @endif>
									</div>
								</div>
								<label class="d-block">Address</label>
								<div class="row m-md-0">
									<div class="col-md mb-1 mb-md-3 p-md-0">
										<input type="text" class="form-control{{ $errors->has('addr1') ? ' is-invalid' : '' }}" name="addr1" value="{{ $company->address->addr1  }}" placeholder="Street Address">
									</div>
									<div class="col-md-5 mb-3 p-md-0 pl-md-1">
										<input type="text" class="form-control{{ $errors->has('addr2') ? ' is-invalid' : '' }}" name="addr2" value="{{ $company->address->addr2 ? $company->address->addr2 : '' }}" placeholder="Building, Suite, Floor, etc">
									</div>
								</div>
								<div class="invalid-feedback">
									{{ $errors->first('addr1') }}
								</div>
								<div class="row">
									<div class="col-md-7 col-lg-6 mb-3">
										<label class="d-block label_required">Country</label>
										<select class="select2 form-control {{ $errors->has('country') ? ' is-invalid' : '' }}" id="country_id" name="country">
											<option disabled hidden selected value="">-- Select --</option>
											@foreach($countries as $country)
												<option value="{{$country->id}}" {{ $company->country_id == $country->id? 'selected' : ''  }}>{{$country->name}}</option>
											@endforeach
										</select>
										<div class="invalid-feedback">
											{{ $errors->first('country') }}
										</div>
									</div>
									<div class="col-md-5 col-lg-6 mb-3">
										<label class="d-block" id="city_lbl">City</label>
										<input type="text" id="city_input" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ $company->address->city }}" placeholder="City">
										<div class="invalid-feedback">
											{{ $errors->first('city') }}
										</div>
									</div>
									<div class="col-sm-7 col-lg-6 mb-3">
										<label class="d-block" id="state_lbl">State</label>
										<select class="form-control{{ $errors->has('company_state') ? ' is-invalid' : '' }}" name="company_state" id="state_option">
											<option disabled hidden selected value="">-- Select --</option>
											@foreach($state as $state)
												<option value="{{$state->id}}" {{ $company->address->state_province == $state->id ? 'selected' : ''}} >{{$state->name}}</option>
											@endforeach
										</select>
										<input type="text" placeholder="Province" name="company_state" id="state_text" class="form-control" value="{{ $country->name != 'United States' ? $company->address->state_province : ''}}">
										<div class="invalid-feedback">
											{{ $errors->first('province') }}
										</div>
									</div>
									<div class="col-sm-5 col-lg-6 mb-3">
										<label class="d-block" id="zip_lbl">Postal Code</label>
										<input type="text" id="zip_input" class="form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}" name="zipcode" value="{{ $company->address->zipcode }}" placeholder="Postal Code">
										<div class="invalid-feedback">
											{{ $errors->first('zipcode') }}
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer d-flex justify-content-end">
								<input type="hidden" name="company_id" value="{{$company->id}}">
								<input type="hidden" name="address_id" value="{{$company->address_id}}">
								<button class="btn btn-success" type="submit">
									<i class="far fa-check"></i> Update
								</button>
							</div>
						</form>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xwebdesc" role="tabpanel" aria-labelledby="xwebdesc-tab">
						<form name="" method="POST" action="{{ route('eac.portal.company.desc.update') }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="card-body">
								<h5 class="mb-3">
									<strong>Description</strong> to be viewed on the EAC website
								</h5>
								<textarea class="form-control basic-editor" name="desc" rows="10">{{ $company->desc }}</textarea>
							</div>
							<div class="card-footer d-flex justify-content-end">
								<input type="hidden" name="company_id" value="{{$company->id}}">
								<button class="btn btn-success" type="submit">
									<i class="far fa-check"></i> Update
								</button>
							</div>
						</form>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xcontacts" role="tabpanel" aria-labelledby="xcontacts-tab">
						<div class="card-body">
							<h5 class="mb-3">
								{{ $company->name }} Departments
								@if($company->departments->count() > 0)
									<span class="badge badge-dark">
										{{$company->departments->count()}}
									</span>
								@endif
							</h5>
							@if($company->departments->count() > 0)
								<div class="row">
									@foreach($company->departments as $department)
										<div class="col-md-6 mb-3">
											<div class="card h-100 border-light bs-no border">
												<div class="card-body p-3">
													<h6 class="mb-2 strong">
														{{$department->name}}
													</h6>
													<div class="row m-0 small mb-1">
														<div class="col-auto p-0">
															<i class="text-secondary fa-fw fas fa-phone fa-rotate-90"></i>
														</div>
														<div class="col pl-2 pr-0 wraphelp">
															@if($department->phone_id)
																{{$department->phone->number}}
															@else
																<span class="text-muted">N/A</span>
															@endif
														</div>
													</div><!-- /.row -->
													<div class="row m-0 small">
														<div class="col-auto p-0">
															<i class="text-secondary fa-fw fas fa-envelope"></i>
														</div>
														<div class="col pl-2 pr-0 wraphelp">
															@if($department->email)
																{{$department->email}}
															@else
																<span class="text-muted">N/A</span>
															@endif
														</div>
													</div><!-- /.row -->
												</div>
												<div class="card-footer alert-secondary p-2 d-flex justify-content-between">
													<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editDept{{$department->id}}" title="Edit Department">
														<i class="far fa-fw fa-edit"></i> Edit
													</button>
													<button type="button" class="btn btn-danger btn-sm" onclick="Confirm_Delete('{{$department->id}}')" href="#" title="Delete Department">
														<i class="far fa-fw fa-times"></i> Delete
													</button>
												</div>
											</div>
										</div>
										@include('include.portal.modals.company.editdepartment', $department)
									@endforeach
								</div>
							@else
								<p class="text-muted m-0">
									<i class="fal fa-info-circle"></i> No departments available
								</p>
							@endif
						</div>
						<div class="card-footer d-flex justify-content-end">
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNewDept">
								Add Department
							</button>
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xusers" role="tabpanel" aria-labelledby="xusers-tab">
						<h5 class="p-3">
							User Groups </h5>
						@if($company->user_groups->count() > 0)
							<div class="pre-scrollablex p-3">
								<div class="row">
									@foreach($company->user_groups->sortBy('name') as $userGroup)
										<div class="col-md-6 mb-3">
											<div class="card h-100 border-light bs-no border">
												<div class="card-body pl-3 pr-3 pb-3 pt-2">
													<span class="badge p-0 text-secondary">{{$userGroup->type->name}} Group</span>
													<h6 class="mb-2">
														<strong>{{$userGroup->name}}</strong>
													</h6>
													<div class="row mb-2 mb-lg-1 small">
														<div class="col-sm col-md-12 col-lg">
															<a href="{{ route('eac.portal.user.show', $userGroup->parent->id) }}">
																{{$userGroup->parent->full_name}}
															</a>
														</div>
														<div class="col-sm-5 col-md-12 col-lg-auto">
															Group Lead
														</div>
													</div>
													@foreach($userGroup->users()->sortBy('first_name') as $user)
														@if($user)
															<div class="row mb-2 mb-lg-1 small">
																<div class="col-sm col-md-12 col-lg">
																	<a href="{{ route('eac.portal.user.show', $user->id) }}">
																		{{$user->full_name}}
																	</a>
																</div>
																<div class="col-sm-5 col-md-12 col-lg-auto">
																	{{$userGroup->roleInTeam($user->id)->name}}
																</div>
															</div>
														@endif
													@endforeach
												</div>
												<div class="card-footer alert-secondary p-2 text-right">
													<a class="btn btn-danger btn-sm" href="{{route('eac.portal.company.group.remove', $userGroup->pivot->id)}}" title="Unassign User Group">
														<i class="far fa-fw fa-times"></i>
														Unassign
													</a>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						@else
							<span class="text-muted p-3">No user groups have been assigned</span>
						@endif
						<div class="card-footer text-right p-3">
							<button type="button" class="btn btn-success window-btn" data-toggle="modal" data-target="#addRidTeam">
								Assign User Group
							</button>
						</div>
						@include('include.portal.modals.company.group.add')
					</div><!-- /.tab-pane -->
				</div>
			</div>
		</div>
	</div><!-- end .editData -->
	
	<div class="modal fade" id="addNewDept" tabindex="-1" role="dialog" aria-labelledby="addNewDeptLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Add New Department </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<form method="post" action="{{ route('eac.portal.company.department.create') }}">
					{{ csrf_field() }}
					<input type="hidden" name="company_id" value="{{ $company->id }}"/>
					<div class="modal-body p-3">
						<div class="mb-3">
							<label class="d-block">Department Name</label>
							<input type="text" class="form-control" name="name">
						</div>
						<div class="row">
							<div class="col-sm mb-3">
								<label class="d-block">Phone Number</label>
								<input type="number" class="form-control" name="phone">
							</div>
							<div class="col-sm mb-3">
								<label class="d-block">Email Address</label>
								<input type="email" class="form-control" name="email">
							</div>
						</div><!-- /.row -->
					</div>
					<div class="modal-footer p-2 d-flex justify-content-between">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-success">
							Save
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>


@endsection

@section('scripts')
	
	<script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2();
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
            }
        });

        function Confirm_Delete(param) {

            swal({
                title: "Are you sure?",
                text: "Want to delete it",
                icon: "warning",
                buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                ],
                dangerMode: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Successfull!',
                        text: 'Content deleted!',
                        icon: 'success'
                    }).then(function () {
                        $.get("{{route('eac.portal.company.department.delete')}}",
                            {
                                id: param
                            });
                        // return false;
                        swal.close();
                        var redirect_url = '<?php echo route('eac.portal.company.edit', $company->id); ?>';
                        $(location).attr('href', redirect_url); // <--- submit form programmatically
                    });
                } else {
                    swal("Cancelled", "Operation cancelled", "error");
                }
            })
        }
	</script>
@endsection
