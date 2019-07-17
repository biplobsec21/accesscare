@extends('layouts.portal')

@section('title')
	@if(Auth::User()->id == $user->id)
		My Profile
	@else
		View User
	@endif
@endsection

@section('styles')
	<style>
		.hide-tab {
			display: none;
		}

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
							<a href="{{ route('eac.portal.user.list') }}">All Users</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							{{$user->full_name}}
						</li>
					</ol>
				</div>
			</div>
		</nav>
		<h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{$user->full_name}}
		</h2>
		<div class="small">
			@if($user->last_seen)
				<strong>Last Login:</strong>
				{{$user->last_seen->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A')}}
			@endif
			@if($user->updated_at)
				<strong>Last Updated:</strong>
				{{$user->updated_at->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A')}}
			@endif
		</div>
	</div><!-- end .titleBar -->
	<div class="viewData">
  @if(Auth::user()->type->name == 'Early Access Care')
   @if($user->status === 'Pending')
    <div class="alert alert-warning mb-3" role="alert">
     <h5 class="text-danger">
      <i class="fas fa-exclamation-triangle"></i> User Pending
     </h5>
     <p class="text-dark mb-0">
      <strong>{{ $user->first_name }} {{ $user->last_name }}</strong> is unable to submit content at this time, user must be Approved in order to proceed.
     </p>
    </div><!-- end alert -->
   @elseif($user->status === 'Approved')
    <div class="alert alert-success mb-3" role="alert">
     <h5 class="text-primary">
      <i class="fas fa-check-circle"></i> Authorized
     </h5>
     <p class="text-dark mb-0">
      <strong>{{ $user->full_name }}</strong>
      is able to access content.
     </p>
    </div>
   @else
    <div class="alert alert-warning mb-3" role="alert">
     <h5 class="text-danger">
      <i class="fas fa-exclamation-triangle"></i> Not Authorized
     </h5>
     <p class="text-dark mb-0">
      <strong>{{ $user->full_name }}</strong> is unable to access content at this time, user must be re-authorized in order to proceed.
     </p>
    </div><!-- end alert -->
   @endif
  @endif
		<div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
			<a href="{{ route("eac.portal.user.list") }}" class="btn btn-light">
				<i class="fa-fw fas fa-arrow-left"></i> Return to User List
			</a>
			<div>
				@if(\Auth::user()->type->name == 'Early Access Care')
					<a href="{{ route('eac.auth.emu.init', $user->id) }}" class="btn btn-primary">
						<i class="fas fa-sign-in-alt" aria-hidden="true"></i> Sign In As User
					</a>
				@endif
				@access('user.index.update')
				<a href="{{ route('eac.portal.user.edit', $user->id) }}" class="btn btn-info">
					<i class="far fa-edit"></i> Edit User
				</a>
				@endif
			</div>
		</div>
		<div class="row thisone m-0 mb-xl-5">
			<div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
				<div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist"
					 aria-orientation="vertical">
					<a class="nav-link complete" id="xdetails-tab" data-toggle="pill" href="#xdetails" role="tab"
					   aria-controls="xdetails" aria-selected="true">
						<span>Details</span>
					</a>
					<a class="nav-link {{ $user->assignedTo()->count() > 0 ? 'complete' : '' }}"
					   id="xassigned-tab" data-toggle="pill" href="#xassigned" role="tab" aria-controls="xassigned"
					   aria-selected="true">
						<span>Assigned Items</span>
					</a>
					<a class="nav-link {{ $user->groups() ? 'complete' : 'hide-tab' }}" id="xgroups-tab"
					   data-toggle="pill" href="#xgroups" role="tab" aria-controls="xgroups" aria-selected="false">
						<span>User Groups</span>
					</a>
					@access('user.note.view')
					@if($user->notes()->count() > 0)
						<a class="nav-link complete" id="xnotes-tab" data-toggle="pill" href="#xnotes" role="tab"
						   aria-controls="xnotes" aria-selected="false">
							<span>User Notes</span>
						</a>
					@endif
					@endif
				</div>
			</div>
			<div class="col-sm-9 col-xl p-0">
				<div class="card tab-content wizardContent" id="tabContent">
					<div class="alert-light text-dark pt-3 pl-3 pr-3">
						<div class="row">
							<div class="col mb-3">
								<strong>{{ $user->full_name }}</strong>
								<span class="badge badge-{{ config('eac.user.availableStatus.' . $user->status) }}">
									{{ $user->status }}
								</span>
								<ul class="nav flex-row m-0">
									@if($user->phone && $user->phone->number)
										<li class="nav-item">
											<a href="tel:{{ $user->phone->number }}" class="small" data-toggle="tooltip"
											   data-placement="bottom" title="Call {{ $user->phone->number }}">
												<i class="text-secondary fa-fw fas fa-phone fa-sm fa-rotate-90"></i>
											</a>
										</li>
									@endif
									@if(($user->phone && $user->phone->number) && ($user->email))
										<li class="nav-item pl-2 pr-2 d-none d-sm-block text-secondary">|</li>
									@endif
									@if($user->email)
										<li class="nav-item">
											<a href="mailto:{{ $user->email }}" class="small" data-toggle="tooltip"
											   data-placement="bottom" title="Email {{ $user->email }}">
												<i class="text-secondary fa-fw fas fa-envelope fa-sm"></i>
											</a>
										</li>
									@endif
									@if($user->address)
										<li class="nav-item pl-2 pr-2 d-none d-sm-block text-secondary">|</li>
										<li class="nav-item">
											<a href="#" class="small" data-html="true" data-toggle="popover"
											   data-content=" {!! $user->address->strDisplay() !!}"
											   data-placement="bottom">
												<i class="text-secondary fa-fw fas fa-map-marker-alt fa-sm"></i>
											</a>
										</li>
									@endif
								</ul>
							</div>
							<div class="col-md mb-3">
        <small class="upper d-block">User Type</small>
        <strong>{{ $user->type->name }}</strong>
								@if($user->company)
									<span class="d-inline-block">
										(<a href="{{ route('eac.portal.company.show', $user->company->id) }}">{{ $user->company->name }}</a>)
									</span>
								@endif
							</div>
							<div class="col-auto mb-3">
								<small class="upper d-block">Created On</small>
								<strong>{{ $user->created_at->format(config('eac.date_format')) }}</strong>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="xdetails" role="tabpanel" aria-labelledby="xdetails-tab">
						<div class="card-body mb-0">
							<div class="row">
								<div class="col col-sm-7 col-md-9 mb-3 mb-xl-2">
									<div class="mb-3 mb-xl-2">
										<strong>{{ $user->full_name }}</strong>
									</div>
									<ul class="nav flex-column flex-sm-row mb-0 mb-xl-1">
										@if($user->phone && $user->phone->number)
											<li class="nav-item">
												<a href="tel:{{ $user->phone->number }}" class="btn btn-link p-0"
												   data-toggle="tooltip" data-placement="bottom"
												   title="Call {{ $user->phone->number }}">
													<i class="text-secondary fa-fw fas fa-phone fa-rotate-90"></i> Phone
												</a>
											</li>
										@endif
										@if(($user->phone && $user->phone->number) && ($user->email))
											<li class="nav-item pl-2 pr-2 d-none d-sm-block">|</li>
										@endif
										@if($user->email)
											<li class="nav-item">
												<a href="mailto:{{ $user->email }}" class="btn btn-link p-0"
												   data-toggle="tooltip" data-placement="bottom"
												   title="Email {{ $user->email }}">
													<i class="text-secondary fa-fw fas fa-envelope"></i> Email
												</a>
											</li>
										@endif
									</ul>
								</div>
								<div class="col-auto col-sm-5 col-md-3 mb-3 mb-xl-2">
									<span class="badge badge-{{ config('eac.user.availableStatus.' . $user->status) }}">
										{{ $user->status }}
									</span>
								</div>
								<div class="col-sm-7 col-md-9">
									@if(isset($user->address))
										<div class="mb-2">
											{!! $user->address->strDisplay() !!}
										</div>
									@endif
									<div class="row">
										<div class="col-lg-5 mb-3 mb-lg-0">
											<label class="text-muted d-block">User Type</label>
											{{ $user->type->name }}
										</div>
										@if($user->company)
											<div class="col-lg mb-3 mb-sm-0">
												<label class="text-muted d-block">Company</label>
												<a href="{{ route('eac.portal.company.show', $user->company->id) }}">
													{{ $user->company->name }}
												</a>
											</div>
										@endif
									</div>
								</div>
								<div class="col-sm-5 col-md-3">
									<label class="text-muted d-block">Added</label>
									{{ $user->created_at->toDateString() }}
								</div>
							</div>
							@if($user->type->name == "Physician")
								<hr/>
								<h5 class="text-gold mb-2">Professional Documents</h5>
								@if($user->certificate)
									<ul class="m-0">
										@if($user->certificate->cv_file)
											<li>
												<a href="{{ route('eac.portal.file.download', $user->certificate->cv_file) }}">
													Curriculum Vitae/Resume
												</a>
											</li>
										@endif
										@if($user->certificate->medicalLicense)
											<li>
												<a href="{{ route('eac.portal.file.download', $user->certificate->license_file) }}">
													Medical License
												</a>
											</li>
										@endif
									</ul>
								@else
									<p class="text-info m-0">No professional documents to display</p>
								@endif
							@endif
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xassigned" role="tabpanel"
						 aria-labelledby="xassigned-tab">
						<div class="card-body">
							<h5 class="">
								Assigned Items
							</h5>
							Rids
							@if($rids)
       <span class="badge badge-success">{{$rids->count()}}</span>
								<ul>
								@foreach($rids as $rid)
									<li><a href="{{$rid->view_route}}">{{$rid->number}}</a></li>
								@endforeach
								</ul>
							@else
								<p class="text-muted m-0">
									<i class="fal fa-info-circle"></i> No Accessible Rids
								</p>
							@endif
							<hr>
							Drugs
							@if($drugs)
								<ul>
									@foreach($drugs as $drug)
										<li><a href="{{$drug->view_route}}">{{$drug->name}}</a></li>
									@endforeach
								</ul>
							@else
								<p class="text-muted m-0">
									<i class="fal fa-info-circle"></i> No Accessible Drugs
								</p>
							@endif
						</div>
					</div>
					<div class="tab-pane fade " id="xgroups" role="tabpanel" aria-labelledby="xgroups-tab">
						<div class="card-body">
							<h5 class="">
								User Groups <span class="badge badge-dark"></span>
							</h5>
							@if($user->groups())
								<ul class="list-group list-group-flush">
									@foreach($user->groups() as $team)
										<li class="list-group-item">
											<div class="row">
												<div class="col-sm mb-3">
													{{$team->name}}
												</div>
												<div class="col-sm mb-3">
													{{$team->roleInTeam($user->id)->name}}
													@if($user->id == $team->parent_user_id)
														<strong>(Group Lead)</strong>@endif
												</div>
											</div>
										</li>
									@endforeach
								</ul>
							@else
								<p class="text-muted m-0">
									<i class="fal fa-info-circle"></i> No information available
								</p>
							@endif
						</div>
					</div><!-- /.tab-pane -->
					@access('user.note.view')
					<div class="tab-pane fade " id="xnotes" role="tabpanel" aria-labelledby="xnotes-tab">
						<div class="card-body">
							<h5 class="">
								User Notes
							</h5>
							@if($user->notes()->count() > 0)
								<ul class="list-group m-0 list-group-flush">
									@foreach($user->notes()->sortBy('created_at') as $note)
										<li class="list-group-item pt-2 pl-0 pr-0 pb-2">
											<label class="d-block">
												<a href="{{ route('eac.portal.user.show', $note->author->id) }}">
													{{ $note->author->full_name ?? 'N/A' }}
												</a>
												<small>{{ $note->created_at->format('Y-m-d  h:m A') }}</small>
											</label>
											<p class="m-0">{{ $note->text }}</p>
										</li>
									@endforeach
								</ul>
							@else
								<p class="text-muted mb-0">
									<i class="fal fa-info-circle"></i> No information available
								</p>
							@endif
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	{{--  new [wizard based design] new design concept <end> here  --}}

	{{-- previous design --}}
	{{-- <div class="viewData">
	<div class="row">
	<div class="col-xl">
	<div class="tabs2o">
	<ul class="nav nav-tabs" id="tabBlok3" role="tablist">
	<li class="nav-item">
	<a class="nav-link active" id="details3-tab" data-toggle="tab" href="#details3" role="tab"
	aria-controls="details3" aria-selected="true">
	Details
	</a>
	</li>
	<li class="nav-item">
	<a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab"
	aria-controls="notes"
	aria-selected="false">
	Notes
	</a>
	</li>
	</ul>
	<div class="card tab-content mb-3 mb-xl-5" id="tabBlok3Content">
	<div class="tab-pane fade show active" id="details3" role="tabpanel"
	aria-labelledby="details3-tab">
	<div class="card-body">
	<div class="mb-3">
	<label class="d-block">Name</label>
	{{ $user->full_name }}
	</div>
	<div class="mb-3">
	<label class="d-block">Type</label>
	{{ $user->type->name }}
	</div>
	<div class="mb-3">
	<label class="d-block">Status</label>
	<span class="badge badge-{{ config('eac.user.availableStatus.' . $user->status) }}">
	{{ $user->status }}
	</span>
	</div>
	@if($user->company)
	<div class="mb-3">
	<label class="d-block">
	Company
	</label>
	<a href="{{ route('eac.portal.company.show', $user->company->id) }}">
	{{ $user->company->name }}
	</a>
	<!-- need company address -->
	</div>
	@endif
	<div class="mb-3">
	<label class="d-block">Address</label>
	@if(isset($user->address->addr1))
	{{ $user->address->addr1 }} <br/>
	@if(isset($user->address->addr2))
	{{ $user->address->addr2 }} <br/>
	@endif
	{{ $user->address->city }},
	@if($user->address->state) {{ $user->address->state->abbr }} @endif {{ $user->address->zipcode }}
	<br/>
	@if($user->address->country) {{ $user->address->country->name }} @endif
	@else
	No address data.
	@endif
	</div>
	<div class="mb-3">
	<label class="d-block">Primary Email Address</label>
	<a href="mailto:{{ $user->email }}">
	{{ $user->email }}
	</a>
	</div>
	<div class="mb-3">
	<label class="d-block">Phone Number</label>
	@if($user->phone)
	<a href="tel:{{ $user->phone->number }}">
	{{ $user->phone->number }}
	</a>
	@else
	No phone data.
	@endif
	</div>
	<div class="">
	<label class="d-block">
	Account Added
	</label>
	{{ $user->created_at->toDateString() }}
	</div>
	@if($user->type == "Physician")
	<hr/>
	<h5 class="text-gold mb-2">Professional Documents</h5>
	@if($user->certificate)
	<ul class="m-0">
	@if($user->certificate->cv_file)
	<li>
	<a href="{{ route('eac.portal.file.download', $user->certificate->cv_file) }}">
	Curriculum Vitae/Resume
	</a>
	</li>
	@endif
	@if($user->certificate->medicalLicense)
	<li>
	<a href="{{ route('eac.portal.file.download', $user->certificate->license_file) }}">
	Medical License
	</a>
	</li>
	@endif
	</ul>
	@else
	<p class="text-info m-0">No professional documents to display</p>
	@endif
	@endif
	</div>
	</div>
	<div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
	<div class="card-body">
	<p class="text-info m-0">
	<i class="far fa-tools"></i> Coming Soon!
	</p>
	</div>
	</div>
	<div class="tab-pane fade" id="alternate" role="tabpanel" aria-labelledby="alternate-tab">
	<div class="card-body">
	@if($user->type !== "Physician")
	Drugs reviewed/submitted
	<p class="text-info m-0">
	<i class="far fa-tools"></i> Coming Soon!
	</p>
	@elseif($user->type !== "Pharmaceutical")
	Shipping Destinations
	<p class="text-info m-0">
	<i class="far fa-tools"></i> Coming Soon!
	</p>
	@endif
	</div>
	</div>
	<div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
	<div class="card-body">
	@if($user->notes()->count())
	<ul class="list-group m-0 list-group-flush">
	@foreach($user->notes()->orderBy('created_at', 'DESC')->get() as $note)
	<li class="list-group-item pt-2 pl-0 pr-0 pb-2">
	<label class="d-block">
	<a href="{{ route('eac.portal.user.show', $note->author->id) }}">
	{{ $note->author->full_name ?? 'N/A' }}
	</a>
	<small>{{ $note->created_at->format('Y-m-d  h:m A') }}</small>
	</label>
	<p class="m-0">{{ $note->text }}</p>
	</li>
	@endforeach
	</ul>
	@else
	<p class="text-muted mb-0">
	<i class="fal fa-info-circle"></i> No information available
	</p>
	@endif
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class="col-lg-7 col-xl-8">
	<div class="tabs2o">
	<ul class="nav nav-tabs" id="tabBlok2" role="tablist">
	<li class="nav-item">
	<a class="nav-link active" id="assigned2-tab" data-toggle="tab" href="#assigned2" role="tab"
	aria-controls="assigned2" aria-selected="true">
	Assigned Items
	</a>
	</li>
	<li class="nav-item">
	<a class="nav-link" id="permission2-tab" data-toggle="tab" href="#teams2" role="tab"
	aria-controls="teams2" aria-selected="false">
	User Groups
	</a>
	</li>
	</ul>
	<div class="card-body tab-content mb-3 mb-xl-5 " id="tabBlok2Content">
	<div class="tab-pane fade show active" id="assigned2" role="tabpanel"
	aria-labelledby="assigned2-tab">
	@foreach($user->assignedTo() as $assigned)
	<div class="row">
	<div class="col">{{$assigned->class}}</div>
	<div class="col">
	<a href="{{$assigned->object->view_route}}">
	{{$assigned->object->name}}
	</a>
	</div>
	<div class="col">{{$assigned->role->name ?? $assigned->role}}</div>
	</div>
	@endforeach
	</div>
	<div class="tab-pane fade" id="teams2" role="tabpanel" aria-labelledby="teams2-tab">
	<ul class="list-group list-group-flush">
	@foreach($user->groups() as $team)
	<li class="list-group-item">
	{{$team->name}}
	<span
	class="float-right">{{$team->roleInTeam($user->id)->name ?? $team->roleInTeam($user->id)}}</span>
	</li>
	@endforeach
	</ul>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div> --}}<!-- /.viewData -->


@endsection
@section('scripts')
	<script type="text/javascript">
		// Data Tables
		$(document).ready(function () {
			$('#assocRidListTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search")) {
					$(this).text("");
					return;
				}
				var title = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
			});


			var dataTable = $('#assocRidListTBL').DataTable({
				"paginationDefault": 10,
				"paginationOptions": [10, 25, 50, 75, 100],
// "responsive": true,
				'order': [[0, 'desc']],
				"ajax": {
					url: "{{route('eac.portal.user.ajax.rid.list', $user->id)}}",
					type: "post"  // method  , by default get
				},
				"processing": true,
				"serverSide": true,
				"columns": [
// {"data": "req_date"},
					{"data": "number", "name": "number"},
// {"data": "visits"},
					{"data": "status"},
					{"data": "physician_name"},
					{"data": "drug_name"},
					{"data": "ops_btns", orderable: false},
				]
			});

			dataTable.columns().every(function () {
				var that = this;

				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that
							.search(this.value)
							.draw();
					}
				});
			});

			dataTable.columns().every(function () {
				var that = this;
				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that.search(this.value).draw();
					}
				});
			});

			$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
				swal({
					title: "Oh Snap!",
					text: "Something went wrong on our side. Please try again later.",
					icon: "warning",
				});
			};

		}); // end doc ready
	</script>
@endsection
