@extends('layouts.portal')

@section('title')
	Edit Website Properties
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

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.settings.document.type') }}">Document Type Manager</a>
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
	<div class="actionBar">
		<a class="btn btn-success" href="{{route('eac.portal.settings.manage.website.properties.show',$rows->id)}}"
		   class="btn btn-secondary">
			<i class="fal fa-angle-double-left"></i> View Properties
		</a>
	</div><!-- end .actionBar -->

	<div class="viewData">
		<div class="row thisone m-0 mb-xl-5">
			<div class="col-sm-3 col-xl-auto p-0 pr-sm-2 mb-2 mb-sm-0">
				<div class="wizardSteps symbols nav flex-row flex-sm-column" id="tab" role="tablist"
					 aria-orientation="vertical">
					<a class="nav-link active" id="xdetails-tab" data-toggle="pill" href="#xdetails" role="tab"
					   aria-controls="xdetails" aria-selected="true">
						<span>Website Settings</span>
					</a>
					<a class="nav-link" id="xstatus-tab" data-toggle="pill" href="#xstatus" role="tab"
					   aria-controls="xstatus" aria-selected="false">
						<span>RID Status Manager</span>
					</a>
				</div>
			</div>
			<div class="col-sm-7 col-lg-6 col-xl-auto p-0 pl-sm-2">
				<div class="card tab-content wizardContent" id="tabContent">
					<div class="tab-pane fade show active" id="xdetails" role="tabpanel"
						 aria-labelledby="xdetails-tab">
						<form action="{{ route('eac.portal.settings.manage.website.properties.update',$rows->id) }}"
							  method="post" enctype='multipart/form-data'>
							{{ csrf_field() }}
							<div class="card-body">
								<h5 class="text-gold">Company Settings</h5>
								<div class="row">
									<div class="col-md">
										<div class="mb-3">
											<label for="" class="d-block">Company Name</label>
											<input type="hidden" value="{{$rows->id}}" name="company_id"/>
											<input type="text" value="{{$rows->name}}"
												   class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}"
												   name="company_name"/>
											<div class="invalid-feedback">
												{{ $errors->first('company_name') }}
											</div>
										</div>
									</div>
									<div class="col-md">
										<div class="mb-3">
											<label for="" class="d-block">Company Established</label>
											<input type="number" name="company_est"
												   class="form-control{{ $errors->has('company_est') ? ' is-invalid' : '' }}"
												   value="{{$rows->establishment}}"/>
											<div class="invalid-feedback">
												{{ $errors->first('company_est') }}
											</div>
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label for="" class="d-block">Street Address</label>
									<input type="text" name="company_addr_1"
										   class="mb-2 form-control{{ $errors->has('company_addr_1') ? ' is-invalid' : '' }}"
										   value="{{$rows->addr1}}"/>
									<div class="invalid-feedback">
										{{ $errors->first('company_addr_1') }}
									</div>
									<input type="text" class="form-control" name="company_addr_2"
										   value="{{$rows->addr2}}"/>
								</div>
								<div class="row">
									<div class="col-sm">
										<div class="mb-3">
											<label for="" class="d-block">City</label>
											<input type="text" name="company_city" value="{{$rows->city}}"
												   class="form-control{{ $errors->has('company_city') ? ' is-invalid' : '' }}"/>
											<div class="invalid-feedback">
												{{ $errors->first('company_city') }}
											</div>
										</div>
									</div>
									<div class="col-sm">
										<div class="mb-3">
											<label for="" class="d-block">State</label>
											<select
												class="select2 form-control{{ $errors->has('company_state') ? ' is-invalid' : '' }}"
												name="company_state">
												<option disabled hidden selected value="">-- Select --</option>
												@foreach($state as $state)
													<option
														value="{{$state->name}}" {{ $rows->state == $state->name? 'selected' : ''  }}>{{$state->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm">
										<div class="mb-3">
											<label for="" class="d-block">Zip</label>
											<input type="number" name="company_zip"
												   class="form-control{{ $errors->has('company_zip') ? ' is-invalid' : '' }}"
												   value="{{$rows->zip}}"/>
											<div class="invalid-feedback">
												{{ $errors->first('company_zip') }}
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm">
										<div class="mb-3">
											<label for="" class="d-block">Phone</label>
											<input type="number" name="company_phone_1"
												   class="form-control{{ $errors->has('company_phone_1') ? ' is-invalid' : '' }}"
												   value="{{$rows->phone1}}"/>
											<div class="invalid-feedback">
												{{ $errors->first('company_phone_1') }}
											</div>
										</div>
									</div>
									<div class="col-sm">
										<div class="mb-3">
											<label for="" class="d-block">Phone
												<small>(alternate)</small>
											</label>
											<input type="number" class="form-control" name="company_phone_2"
												   value="{{$rows->phone2}}"/>
										</div>
									</div>
								</div>
								<hr/>
								<h5 class="text-gold">Website Settings</h5>
								<div class="row">
									<div class="col-md">
										<div class="mb-3">
											<label for="" class="d-block">Email Address</label>
											<input type="email" name="company_email"
												   class="form-control{{ $errors->has('company_email') ? ' is-invalid' : '' }}"
												   value="{{$rows->email}}"/>
											<div class="invalid-feedback">
												{{ $errors->first('company_email') }}
											</div>
										</div>
									</div>
									<div class="col-md">
										<div class="mb-3">
											<label for="" class="d-block">Website URL</label>
											<input type="text" name="company_url"
												   class="form-control{{ $errors->has('company_url') ? ' is-invalid' : '' }}"
												   value="{{$rows->website}}"/>
											<div class="invalid-feedback">
												{{ $errors->first('company_url') }}
											</div>
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label for="" class="d-block">Company Logo <small>({{config('eac.storage.file.type')}})</small></label>
									<div class="input-group">
										<?php if($rows->logo != '') {
										$splitName = explode('/', $rows->logo);
										$logoName = $splitName[2];
										// $doc = \App\WebsiteProperties::where('id',$rows->logo)->first(); ?>
										<input disabled class="form-control" placeholder="{{$logoName}}">
										<div class="form-control-append">
											<a class="btn btn-danger" href="#"
											   onclick="removeLogo('{{$rows->id}}',event)">
												<i class="far fa-trash"></i> Delete File
											</a>
										</div>
										<?php } else{ ?>
										<input type="file" class="form-control" name="company_logo"/>
          <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="card-footer d-flex justify-content-center">
								<button class="btn btn-success" type="submit" value="save">
									<i class="far fa-check"></i> Save Changes
								</button>
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="xstatus" role="tabpanel" aria-labelledby="xstatus-tab">
						<form action="{{ route('eac.portal.rid.badge.update',$rows->id) }}"
							  method="post" enctype='multipart/form-data'>
							{{ csrf_field() }}
							<div class="card-body">
								<h5 class="mb-3">
									RID Status Manager
								</h5>
								<div class="alert alert-light mb-3">
									<small class="d-block upper text-sm-center mb-2">Badge Options</small>
									<div class="d-flex justify-content-sm-between">
										<span class="badge badge-primary">Primary</span>
										<span class="badge badge-secondary">Secondary</span>
										<span class="badge badge-success">Success</span>
										<span class="badge badge-danger">Danger</span>
										<span class="badge badge-warning">Warning</span>
										<span class="badge badge-info">Info</span>
										<span class="badge badge-light">Light</span>
										<span class="badge badge-dark">Dark</span>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-sm table-striped table-hover">
										<thead>
										<tr>
											<th>Label</th>
											<th>Color</th>
										</tr>
										</thead>
										<tbody>
										@foreach(\App\RidMasterStatus::all() as $status)
											<tr>
												<td>
													<input type="text" class="form-control" name="status[{{$status->id}}][name]"
														   value="{{$status->name}}"/>
												</td>
												<td>
													<select class="form-control" name="status[{{$status->id}}][badge]">
														<option disabled hidden value="">-- Select --</option>
														<option value="primary" @if($status->badge == 'primary') selected @endif>Primary</option>
														<option value="secondary" @if($status->badge == 'secondary') selected @endif>Secondary</option>
														<option value="success" @if($status->badge == 'success') selected @endif>Success</option>
														<option value="danger" @if($status->badge == 'danger') selected @endif>Danger</option>
														<option value="warning" @if($status->badge == 'warning') selected @endif>Warning</option>
														<option value="info" @if($status->badge == 'info') selected @endif>Info</option>
														<option value="light" @if($status->badge == 'light') selected @endif>Light</option>
														<option value="dark" @if($status->badge == 'dark') selected @endif>Dark</option>
													</select>
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="card-footer">
								<button class="btn btn-success">
									<i class="far fa-check"></i> Save Changes
								</button>
							</div>
						</form>
					</div><!-- /.tab-pane -->
				</div>
			</div>
		</div><!-- /.row -->
	</div><!-- /.viewData -->


	<!-- end .viewData -->

@endsection
@section('scripts')

	<script type="text/javascript">
		function removeLogo($id, $e) {
			console.log($id);
			$.ajax({
				url: "{{route('eac.portal.settings.manage.website.properties.logo.delete')}}",
				type: 'POST',
				data: {
					id: $id,
				},
				success: function () {
					$e.target.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="company_logo"/>'
				}
			});
		}
	</script>
@endsection
