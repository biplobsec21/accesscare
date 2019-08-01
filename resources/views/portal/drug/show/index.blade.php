@extends('layouts.portal')

@section('title')
	View Drug
@endsection

@section('styles')

	<style>
		.v-inactive {
			display: none;
		}

		.hide-tab {
			display: none;
		}

		.drug-logo {
			max-width: 200px;
		}

		@media screen and (min-width: 1200px) {
			:root {
				--leftCol: 250px;
				--rightCol: 675px;
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

		@media screen and (min-width: 1400px) {
			html {
				--rightCol: 800px;
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
							<a href="{{ route('eac.portal.drug.list') }}">All Drugs</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							{{$drug->name}}
						</li>
					</ol>
				</div>
				<div class="d-none d-sm-block col-sm-auto ml-sm-auto">
					<div class="small">
						<strong>Last Updated:</strong>
						@php
							$time = $drug->updated_at;
							
							echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
						@endphp
					</div>
				</div>
			</div>
		</nav>
		<h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{$drug->name}}
		</h2>
		<div class="small d-sm-none">
			<strong>Last Updated:</strong>
			@php
				$time = $drug->updated_at;
				
				echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
			@endphp
		</div>
	</div><!-- end .titleBar -->
	<div class="viewData">
		<div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
			<a href="{{ route("eac.portal.drug.list") }}" class="btn btn-light">
				Drug List
			</a>
{{--			@if(($history_length = count(session('history'))) > 1)--}}
{{--				<a href="{{ session('history')[$history_length - 2]['url'] }}" class="btn btn-light">--}}
{{--					<i class="far fa-angle-double-left"></i> {{ session('history')[$history_length - 2]['title'] }}--}}
{{--				</a>--}}
{{--			@endif--}}
			<div>
				@access('drug.index.update')
				<a href="{{ route("eac.portal.drug.edit", $drug->id) }}" class="btn btn-info">
					<i class="far fa-edit"></i> Edit Drug
				</a>
				@endif
				{{-- <a href="{{ route('eac.portal.drug.druginfo') }}" class="text-white btn bg-gradient-indigo">
					<i class="fa-fw fas fa-calendar-alt"></i> Drug Supply Information
				</a> --}}
			</div>
		</div>
		<div class="row thisone m-0 mb-xl-5">
			<div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
				<div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist"
					 aria-orientation="vertical">
					<a class="nav-link complete active" id="xavailabilityT" data-toggle="pill" href="#xavailability"
					   role="tab"
					   aria-controls="xavailability" aria-selected="true">
						<span>Availability</span>
					</a>
					<a class="nav-link complete" id="xdrugImageT" data-toggle="pill" href="#xdrugImage"
					   role="tab"
					   aria-controls="xdrugImage" aria-selected="false">
						<span>Drug Image</span>
					</a>
					<a class="nav-link complete" id="xwebdescT" data-toggle="pill" href="#xwebdesc" role="tab"
					   aria-controls="xwebdesc" aria-selected="false">
						<span>Descriptions</span>
					</a>
					<a class="nav-link @if($isComplete['completeCmpDsg'] == 1) complete  @else hide-tab @endif"
					   id="xcomponentsT"
					   data-toggle="pill" href="#xcomponents" role="tab" aria-controls="xcomponents"
					   aria-selected="false">
						<span>Components &amp; Dosages</span>
					</a>
					<a class="nav-link @if($isComplete['completeDpotLot'] == 1) complete  @else hide-tab @endif"
					   id="xdepotsT"
					   data-toggle="pill" href="#xdepots" role="tab" aria-controls="xdepots" aria-selected="false">
						<span>Depots &amp; Lots</span>
					</a>
					<a class="nav-link @if($supply_info->count()) complete @else hide-tab @endif" id="xdrugdistT"
					   data-toggle="pill" href="#xdrugdistTa" role="tab" aria-controls="xdrugdistTa"
					   aria-selected="false">
						<span>Drug Distribution Schedule</span>
					</a>
					<a class="nav-link @if($drug->user_groups->count()) complete  @else hide-tab @endif" id="xgroupsT"
					   data-toggle="pill" href="#xgroups" role="tab" aria-controls="xgroups" aria-selected="false">
						<span>Assigned Groups</span>
					</a>
					<a class="nav-link @if($drug->documents->count()) complete  @else hide-tab @endif" id="xdocumentsT"
					   data-toggle="pill" href="#xdocuments" role="tab" aria-controls="xdocuments"
					   aria-selected="false">
						<span>Form List</span>
					</a>
					<a class="nav-link @if($drug->resources->count()) complete  @else hide-tab @endif" id="xresourcesT"
					   data-toggle="pill" href="#xresources" role="tab" aria-controls="xresources"
					   aria-selected="false">
						<span>Reference Documents</span>
					</a>
					@access('drug.requests.view')
					<a class="nav-link @if($drug->rids->count()) complete  @else hide-tab @endif" id="xridsT"
					   data-toggle="pill" href="#xrids" role="tab"
					   aria-controls="xrids" aria-selected="false">
						<strong class="text-warning">{{$drug->rids->count()}}</strong> Requests
					</a>
					@endif
					<a class="nav-link @if($drug->notes->count()) complete @endif" id="xnotesT"
					   data-toggle="pill" href="#xnotes" role="tab"
					   aria-controls="xnotes" aria-selected="false">
						<strong class="text-warning">{{$drug->notes->count()}}</strong> Notes
					</a>
				</div>
			</div>
			<div class="col-sm-9 col-xl p-0">
				<div class="card tab-content wizardContent" id="tabContent">
					@access('drug.info.view')
					@include('portal.drug.show.details')
					@endif
					<div class="tab-pane fade show active" id="xavailability" role="tabpanel"
						 aria-labelledby="xavailability-tab">
						<div class="card-body">
							<h5 class="mb-1">
								Drug is available in these <strong>countries</strong>:
							</h5>
							@access('drug.info.view')
							<div class="mb-3">
								@if($drug->countries_available && $drug->countries_available != 'null' && $drug->countries_available != '0' )
									@foreach(\App\Country::find(json_decode($drug->countries_available, true)) as $country)
										<a href="#" data-toggle="modal"
										   data-target="#Modal{{$country->id}}">{{$country->name}}</a>,
										@include('include.portal.modals.rid.country.available_country', $country)
									@endforeach
									<div class="mt-2">
										<label class="h5 mb-0 d-block">Hide Countries on EAC Website</label>
										@if($drug->hide_countries)
											<span class="badge badge-dark">Yes</span>
										@else
											<span class="badge badge-light">No</span>
										@endif
									</div>
								@else
									<small class="text-muted">N/A</small>
								@endif
							</div>
							<div class="mb-3">
								<label class="h5 mb-0 d-block">Pre-Approval Required</label>
								@if($drug->pre_approval_req)
									<span class="badge badge-dark">Yes</span>
								@else
									<span class="badge badge-light">No</span>
								@endif
							</div>
							<div class="mb-3">
								<label class="h5 mb-0 d-block">Ship Without Approval</label>
								@if($drug->ship_without_approval)
									<span class="badge badge-dark">Yes</span>
								@else
									<span class="badge badge-light">No</span>
								@endif
							</div>
							<div class="mb-3">
								<label class="h5 mb-0 d-block">Allow Remote Visits</label>
								@if($drug->allow_remote)
									<span class="badge badge-dark">Yes</span>
								@else
									<span class="badge badge-light">No</span>
								@endif
							</div>
							@endif
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xdrugImage" role="tabpanel" aria-labelledby="xdrugimage-tab">
						<div class="card-body">
							<div class="pre-scrollable small">
								@if(isset($drugLogo->name))
									<img class="img-responsive drug-logo"
										 src="{{ asset('/images')}}/{{$drugLogo->name}}">
								@else
									<img class="img-responsive drug-logo" src="{{ asset('/images')}}/default.png">

								@endif
							</div>
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xwebdesc" role="tabpanel" aria-labelledby="xwebdesc-tab">
						<div class="card-body">
							<h5>
								<strong>Internal</strong> description, only viewable to EAC users
							</h5>
							<div class="pre-scrollable small">
								{!! $drug->desc !!}
							</div>
							@if($drug->short_desc)
								<hr/>
								<h5 class="mb-3">
									<strong>Description</strong> to be viewed on the EAC website
								</h5>
								<div class="pre-scrollable small">
									{!! $drug->short_desc !!}
								</div>
							@endif
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xdocuments" role="tabpanel" aria-labelledby="xdocuments-tab">
						<div class="card-body">
							@access('drug.document.view')
							@serverRender('portal.drug.show.documents')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i> Content unavailable
								</p>
							@endif
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xresources" role="tabpanel" aria-labelledby="xresources-tab">
						<div class="card-body">
							@access('drug.resource.view')
							@serverRender('portal.drug.show.resources')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i> Content unavailable
								</p>
							@endif
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xgroups" role="tabpanel" aria-labelledby="xgroups-tab">
						<div class="card-body">
							@access('drug.user.view')
							@serverRender('portal.drug.show.groups')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i> Content unavailable
								</p>
							@endif
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xdepots" role="tabpanel" aria-labelledby="xdepots-tab">
						<div class="card-body">
							<h5 class="">Depots &amp; Lots</h5>
							@access('drug.depot.view')
							@serverRender('portal.drug.show.depots')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i> Content unavailable
								</p>
							@endif
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xdrugdistTa" role="tabpanel" aria-labelledby="xdrugdistTa-tab">
						<div class="card-body">
							<h5 class="">Drug Distribution Schedule <span
									class="badge badge-dark">{{ $supply_info->count()}}</span></h5>
							@access('drug.supply.view')
							@include('portal.drug.show.supply_info')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i> Content unavailable
								</p>
							@endif
						</div>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xcomponents" role="tabpanel" aria-labelledby="xcomponents-tab">
						<div class="card-body">
							@access('drug.component.view')
							@serverRender('portal.drug.show.dosages')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i> Content unavailable
								</p>
							@endif
						</div>
					</div><!-- /.tab-pane -->
					@access('drug.requests.view')
					<div class="tab-pane fade" id="xrids" role="tabpanel" aria-labelledby="xrids-tab">
						<div class="card-body">
							<h5 class="">
								Requests for {{$drug->name}}
								<span class="badge badge-dark">{{$rids->count()}}</span>
							</h5>
							<div class="table-responsive">
								<table class="table table-sm SObasic table-striped table-hover">
									<thead>
									<tr>
										<th>Request Date</th>
										<th>RID Number</th>
										<th>Status</th>
										<th>Assigned To</th>
										<th></th>
									</tr>
									</thead>
									<tbody>
									@foreach($rids as $rid)
										<tr>
											<td>
												{{\Carbon\Carbon::parse($rid->req_date)->format(config('eac.date_format')) }}
											</td>
											<td>
												<a href="{{route('eac.portal.rid.show',$rid->id)}}">
													{{$rid->number}}
												</a>
											</td>
											<td>
												{{$rid->status->name}}
											</td>
											<td>
												<a href="{{route('eac.portal.user.show', $rid->physician->id)}}">{{$rid->physician->full_name}}</a>
											</td>
											<td></td>
									@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div><!-- /.tab-pane -->
					@endif
					<div class="tab-pane fade" id="xnotes" role="tabpanel" aria-labelledby="xnotes-tab">
						<div class="card-body">
							<h5 class="">
								Notes &amp; Correspondence
								<span class="badge badge-dark">{{$drug->notes->count()}}</span>
							</h5>
							@access('drug.note.view')
							@include('portal.drug.show.notes')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i> Content unavailable
								</p>
							@endif
						</div>
					</div><!-- /.tab-pane -->
				</div>
			</div>
		</div>
	</div>
@endsection


