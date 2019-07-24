@extends('layouts.portal')

@section('title')
	Edit Drug
@endsection

@section('styles')
	<style>
		.group-member-template {
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
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.drug.show', $drug->id) }}">{{ $drug->name }}</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							@yield('title')
						</li>
					</ol>
				</div>
				<div class="d-sm-block col-sm-auto ml-sm-auto">
					<div class="small">
						<strong>Last Updated:</strong>
						{{$drug->updated_at->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A')}}
					</div>
				</div>
			</div>
		</nav>
		<h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{ $drug->name }}
		</h2>
		<div class="small d-sm-none">
			<strong>Last Updated:</strong>
			@php
				$time = $drug->updated_at;
				$time->tz = "America/New_York";
				echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
			@endphp
		</div>
	</div><!-- end .titleBar -->
	@if(Session::has('alerts'))
		{!! view('layouts.alert-dismiss', ['type' => Session::get('alerts')['type'], 'message' => Session::get('alerts')['msg']]) !!}
	@endif
	
	<div class="viewData">
		<div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
			<a href="{{ route('eac.portal.drug.show', $drug->id) }}" class="btn btn-secondary">
				View Drug
			</a>
			<div>
				<div class="btn-group" role="group">
					<button id="btnGroupDrop3" type="button" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Change Status
						<i class="fa-fw fas fa-caret-down"></i>
					</button>
					<div class="dropdown-menu" aria-labelledby="btnGroupDrop3">
						<a class="dropdown-item" href="{{ route('eac.portal.drug.status.change', ['status'=>0,'id'=>$drug->id]) }}">Not approved</a>
						<a class="dropdown-item" href="{{ route('eac.portal.drug.status.change', ['status'=>2,'id'=>$drug->id]) }}">Pending</a>
						<a class="dropdown-item" href="{{ route('eac.portal.drug.status.change', ['status'=>1,'id'=>$drug->id]) }}">Approved</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row thisone m-0 mb-xl-5">
			<div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
				<div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link complete active" id="xdetailsT" data-toggle="pill" href="#xdetails" role="tab" aria-controls="xdetails" aria-selected="true">
						<span>Drug Details</span>
					</a>
					<a class="nav-link complete" id="xavailabilityT" data-toggle="pill" href="#xavailability" role="tab" aria-controls="xavailability" aria-selected="false">
						<span>Availability</span>
					</a>
					<a class="nav-link complete" id="xdrugImageT" data-toggle="pill" href="#xdrugImage" role="tab" aria-controls="xdrugImage" aria-selected="false">
						<span>Drug Image</span>
					</a>
					<a class="nav-link complete" id="xwebdescT" data-toggle="pill" href="#xwebdesc" role="tab" aria-controls="xwebdesc" aria-selected="false">
						<span>Website Description</span>
					</a>
					<a class="nav-link @if($isComplete['completeCmpDsg'] == 1) complete @endif" id="xcomponentsT" href="#xcomponents" data-toggle="pill" role="tab" aria-controls="xcomponents" aria-selected="false">
						<span>Components &amp; Dosages</span>
					</a>
					
					<a class="nav-link @if($isComplete['completeDpotLot'] == 1) complete @endif" id="xdepotsT" href="#xdepots" data-toggle="pill" role="tab" aria-controls="xdepots" aria-selected="false">
						
						<span>Depots &amp; Lots</span>
					</a>
					<a class="nav-link @if($supply_info->count()) complete @endif" id="xdrugdistT" href="#xdrugdistTa" data-toggle="pill" role="tab" aria-controls="xdrugdistTa" aria-selected="false">
						
						<span>Drug Distribution Schedule</span>
					</a>
					<a class="nav-link @if($drug->user_groups->count()) complete @endif" id="xgroupsT" data-toggle="pill" href="#xgroups" role="tab" aria-controls="xgroups" aria-selected="false">
						<span>Assigned Groups</span>
					</a>
					<a class="nav-link @if($drug->documents->count()) complete @endif" id="xdocumentsT" data-toggle="pill" href="#xdocuments" role="tab" aria-controls="xdocuments" aria-selected="false">
						<span>Form List</span>
					</a>
					<a class="nav-link @if($drug->resources->count()) complete @endif" id="xresourcesT" data-toggle="pill" href="#xresources" role="tab" aria-controls="xresources" aria-selected="false">
						<span>Reference Documents</span>
					</a>
					<a class="nav-link @if($drug->rids->count()) complete @endif" id="xridsT" data-toggle="pill" href="#xrids" role="tab" aria-controls="xrids" aria-selected="false">
						<strong class="text-warning">{{$drug->rids->count()}}</strong>
						Requests
					</a>
					<a class="nav-link @if($drug->notes->count()) complete @endif" id="xnotesT" data-toggle="pill" href="#xnotes" role="tab" aria-controls="xnotes" aria-selected="false">
						<strong class="text-warning">{{$drug->notes->count()}}</strong>
						Notes
					</a>
				</div>
			</div>
			<div class="col-sm-9 col-xl p-0">
				<div class="card tab-content wizardContent" id="tabContent">
					@access('drug.info.view', $drug->id)
					@include('portal.drug.show.details')
					@endif
					<div class="tab-pane fade show active" id="xdetails" role="tabpanel" aria-labelledby="xdetails-tab">
						<form method="post" action="{{ route('eac.portal.drug.update') }}" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="drug_id" value="{{$drug->id}}">
							<div class="card-body">
								@access('drug.info.update', $drug->id)
								@include('portal.drug.edit.details')
								@elseaccess('drug.info.view', $drug->id)
								@include('portal.drug.show.details')
								@endif
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-success">
									Save Changes
								</button>
							</div>
						</form>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xavailability" role="tabpanel" aria-labelledby="xavailability-tab">
						<form method="post" action="{{ route('eac.portal.drug.update.availibility') }}" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="drug_id" value="{{$drug->id}}">
							<div class="card-body">
								<h5 class="mb-1">
									Drug is available in these
									<strong>countries</strong>
									:
								</h5>
								@access('drug.info.update', $drug->id)
								<div class="mb-3">
									<select multiple class="form-control select2" name="countries_available[]">
										@foreach($countries as $country)
											@if ($drug->countries_available && collect(json_decode($drug->countries_available))->contains($country->id))
												<option value="{{ $country->id }}" selected>
													{{ $country->name }}
												</option>
											@else
												<option value="{{ $country->id }}">
													{{ $country->name }}
												</option>
											@endif
										@endforeach
									</select>
									<label class="h5 mb-0 d-block mt-2" for="hide_countries">
										<input type="hidden" name="hide_countries" value="0">
										<input type="checkbox" name="hide_countries" id="hide_countries" @if($drug->hide_countries) checked @endif value="1"/>
										Hide Countries on EAC website
									</label>
								</div>
								<div class="mb-3">
									<label class="h5 mb-0 d-block" for="pre_approval_req">
										<input type="hidden" name="pre_approval_req" value="0">
										<input type="checkbox" name="pre_approval_req" id="pre_approval_req" @if($drug->pre_approval_req) checked @endif value="1">
										Pre-Approval is Required
									</label>
								</div>
								<div class="mb-3">
									<label class="h5 mb-0 d-block" for="ship_without_approval">
										<input type="hidden" name="ship_without_approval" value="0">
										<input type="checkbox" name="ship_without_approval" id="ship_without_approval" value="1" @if($drug->ship_without_approval) checked @endif>
										Ship Without Approval
									</label>
								</div>
								<div class="mb-3">
									<label class="h5 mb-0 d-block" for="allow_remote">
										<input type="hidden" name="allow_remote" value="0">
										<input type="checkbox" name="allow_remote" id="allow_remote" @if($drug->allow_remote) checked @endif value="1">
										Allow Remote Visits
									</label>
								</div>
								@elseaccess('drug.info.view', $drug->id)
								<div class="mb-3">
									@if($drug->countries_available && $drug->countries_available != 'null' && $drug->countries_available != '0' )
										@foreach(\App\Country::find(json_decode($drug->countries_available, true)) as $country)
											<a href="#" data-toggle="modal" data-target="#Modal{{$country->id}}">{{$country->name}}</a>,
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
							<div class="card-footer">
								<button type="submit" class="btn btn-success">
									Save Changes
								</button>
							</div>
						</form>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xdrugImage" role="tabpanel" aria-labelledby="xdrugimage-tab">
						<form method="post" action="{{ route('eac.portal.drug.image.update',$drug->id) }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="card-body">
								
								<div class="pre-scrollable small">
									@if(isset($drugLogo->name))
										<img id="imgdrug" class="drug-logo" alt="drug image" src="{{ asset('/images')}}/{{$drugLogo->name}}"/>
									@else
										<img id="imgdrug" class="drug-logo" alt="drug image" src="{{ asset('/images')}}/default.png"/>
									
									@endif
									<input type="hidden" name="drug_id" value="{{$drug->id}}">
									<input type="file" name="drug_image" onchange="document.getElementById('imgdrug').src = window.URL.createObjectURL(this.files[0])">
								</div>
							
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-success">Save Changes</button>
							</div>
						</form>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xwebdesc" role="tabpanel" aria-labelledby="xwebdesc-tab">
						<form method="post" action="{{ route('eac.portal.drug.description.update',$drug->id) }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="card-body">
								<h5 class="mb-3">
									<strong>Description</strong>
									to be viewed on the EAC website
								</h5>
								<textarea class="form-control basic-editor" name="short_desc" rows="10">{{ $drug->short_desc }}</textarea>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-success">Save Changes</button>
							</div>
						</form>
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xcomponents" role="tabpanel" aria-labelledby="xcomponents-tab">
						<div class="card card-body mb-0">
							<h5>
								Components @access('drug.component.view', $drug->id)
								<span class="badge badge-dark">{{ $drug->components->count() }}</span>
								@endif
								and Dosages @access('drug.component.view', $drug->id)
								<span class="badge badge-dark">{{ $dosg->count() }}</span>
								@endif
							</h5>
							@access('drug.component.update', $drug->id)
							@include('portal.drug.edit.dosages')
							@elseaccess('drug.component.view', $drug->id)
							@include('portal.drug.show.dosages')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i>
									Content unavailable
								</p><!-- need to hide entire block if else ^^ -->
							@endif
						</div>
						@access('drug.component.create', $drug->id)
						<div class="card-footer d-flex justify-content-start">
							<button type="button" class="btn btn-success window-btn" data-toggle="modal" data-target="#newComponentModal">
								Add Component
							</button>
						</div>
						@include('include.portal.modals.drugs.component.new')
						@endif
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xdepots" role="tabpanel" aria-labelledby="xdepots-tab">
						<div class="card card-body mb-0">
							<h5 class="text-gold mb-2">
								Depots and Lots
							</h5>
							@access('drug.depot.update', $drug->id)
							@include('portal.drug.edit.depots')
							@elseaccess('drug.depot.view', $drug->id)
							@include('portal.drug.show.depots')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i>
									Content unavailable
								</p>
							@endif
						</div>
						@access('drug.depot.create', $drug->id)
						<div class="card-footer d-flex justify-content-start">
							@if($dosg->count())
								<button type="button" class="btn btn-success window-btn" data-toggle="modal" data-target="#newLotModal">
									Add Lot
								</button>
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i>
									Please add dosages first
								</p>
							@endif
						</div>
						@include('include.portal.modals.drugs.lot.new')
						@endif
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xdrugdistTa" role="tabpanel" aria-labelledby="xdrugdistTa-tab">
						
						@access('drug.supply.update', $drug->id)
						@include('portal.drug.edit.supply')
						@elseaccess('drug.supply.view', $drug->id)
						@include('portal.drug.show.supply_info')
						@else
							<p class="text-danger m-0">
								<i class="far fa-lock"></i>
								Content unavailable
							</p>
						@endif
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xgroups" role="tabpanel" aria-labelledby="xgroups-tab">
						<div class="card card-body mb-0">
							@access('drug.user.update', $drug->id)
							@include('portal.drug.edit.groups')
							@elseaccess('drug.user.view', $drug->id)
							@include('portal.drug.show.groups')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i>
									Content unavailable
								</p>
							@endif
						</div>
						@access('drug.user.create', $drug->id)
						<div class="card-footer d-flex justify-content-start">
							{{-- <button type="button" class="btn btn-primary window-btn" data-toggle="modal"
							data-target="#">
							Add Existing Group
							</button> --}}
							<button type="button" class="ml-3 btn btn-success window-btn" data-toggle="modal" data-target="#AddModal">
								Add New Group
							</button>
						</div>
						@include('include.portal.modals.usergroup.AddModal')
						@endif
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xdocuments" role="tabpanel" aria-labelledby="xdocuments-tab">
						<div class="card card-body mb-0">
							<div class="row mb-3">
								<div class="col">
									<h5 class="mb-0">Form List
									</h5>
								</div>
								<div class="col-auto">
									<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
										<label class="btn btn-secondary active btn-sm" onclick="showactiveOrAll(1)">
											<input type="radio" name="show_active" value="1" autocomplete="off" checked>
											View Active
										</label>
										<label class="btn btn-secondary  btn-sm" onclick="showactiveOrAll(0)">
											<input type="radio" name="show_active" value="0" autocomplete="off">
											View All
										</label>
									</div>
								</div>
							</div>
							@access('drug.document.update', $drug->id)
							@include('portal.drug.edit.documents')
							@elseaccess('drug.document.view', $drug->id)
							@include('portal.drug.show.documents')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i>
									Content unavailable
								</p><!-- need to hide entire block if else ^^ -->
							@endif
						</div>
						@access('drug.document.create', $drug->id)
						<div class="card-footer d-flex justify-content-start">
							<button type="button" class="btn btn-success window-btn" data-toggle="modal" data-target="#newDocumentModal">
								Add Form
							</button>
						</div>
						@include('include.portal.modals.drugs.document.new')
						@endif
						@access('drug.document.update', $drug->id)
						@foreach($drug->documents as $document)
							@include('include.portal.modals.drugs.document.edit', $document)
						@endforeach
						@endif
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xresources" role="tabpanel" aria-labelledby="xresources-tab">
						<div class="card card-body mb-0">
							<div class="row mb-3">
								<div class="col">
									<h5 class="mb-0">Reference Documents @access('drug_resource.view', $drug->id)
										<span class="badge badge-dark">{{ $drug->resources->count() }}</span>
										@endif
									</h5>
								</div>
								<div class="col-auto">
									<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
										<label class="btn btn-secondary active btn-sm" onclick="showactiveOrAll(1)">
											<input type="radio" name="show_active" value="1" autocomplete="off" checked>
											View Active
										</label>
										<label class="btn btn-secondary  btn-sm" onclick="showactiveOrAll(0)">
											<input type="radio" name="show_active" value="0" autocomplete="off">
											View All
										</label>
									</div>
								</div>
							</div>
							@access('drug.resource.update', $drug->id)
							@include('portal.drug.edit.resources')
							@elseaccess('drug.resource.view', $drug->id)
							@include('portal.drug.show.resources')
							@else
								<p class="text-danger m-0">
									<i class="far fa-lock"></i>
									Content unavailable
								</p>
							@endif
						</div>
						@access('drug.resource.create', $drug->id)
						<div class="card-footer d-flex justify-content-start">
							<button type="button" class="btn btn-success window-btn" data-toggle="modal" data-target="#newResourceModal">
								Add Document
							</button>
						</div>
						@endif
						@include('include.portal.modals.drugs.resource.new')
						@access('drug.resource.update', $drug->id)
						@foreach($drug->resources as $resource)
							@include('include.portal.modals.drugs.resource.edit', $resource)
						@endforeach
						@endif
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xrids" role="tabpanel" aria-labelledby="xrids-tab">
						<div class="card-body">
							<h5 class="">
								Requests for {{$drug->name}}
								<span class="badge badge-dark">{{$drug->rids->count()}}</span>
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
									@foreach($drug->rids as $rid)
										<tr>
											<td>
												{{-- {{$rid->req_date->format(config('eac.date_format'))}} --}}
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
					<div class="tab-pane fade" id="xnotes" role="tabpanel" aria-labelledby="xnotes-tab">
						@include('portal.drug.edit.notes')
					</div><!-- /.tab-pane -->
				</div>
			</div>
		</div><!-- /.row -->
	</div><!-- /.viewData -->

@endsection

@section('scripts')
	<script type="text/javascript">
        $(document).ready(function () {

// let $groupSection = $("#type_select");
// $groupSection.find('option').each(function () {
// 			$(this).hide();
// 	});

            $(".tab-pane").each(function () {
                let errorCount = $(this).find('.is-invalid').length;
                if (errorCount) {
                    let link = $('a[aria-controls=' + $(this).attr('id') + ']');
                    link.addClass('invalid');

                }
            });

            $("#parent_id").on('change', function () {

                let $type_id = $('option:selected', this).attr('data-type');
                let $groupSection = $("#type_select");

                $groupSection.val($type_id);
                $('#addMemberBtn').removeClass("disabled");

                let $memberSection = $(".group-member");
                $memberSection.find('select').each(function () {
                    $(this).val($(this).find("option:first").val());
                });
                $memberSection.find('option').each(function () {
                    if ($(this).data('typeid') === $type_id)
                        $(this).show();
                    else
                        $(this).hide();
                });


            });

// On remove button click, remove a group member
            $(document).on('click', 'a.remove', function (e) {
                e.preventDefault();
                $(this).closest('.group-member').remove();
                let $count = 0;
                $('#memberSection').find('.group-member').each(function () {
                    $(this).find('select[name^="member"]').attr('name', 'member[' + $count + ']');
                    $(this).find('select[name^="role"]').attr('name', 'role[' + $count + ']');
                    $count++;
                });
            });

// On Type Change
            $("#type_select").change(function () {
                let $type_id = $(this).val();
                let $memberSection = $("tr");
                console.log($memberSection);
                $('#addMemberBtn').removeClass("disabled");
                $memberSection.find('select').each(function () {
                    $(this).val($(this).find("option:first").val());
                });
                $memberSection.find('option').each(function () {
                    if ($(this).data('typeid') === $type_id)
                        $(this).show();
                    else
                        $(this).hide();
                });
            });
        });

        $('.select2').select2({
            placeholder: 'Select Countries'
        });

        function removeTemplate($id, $e) {
            $.ajax({
                url: "{{route('eac.portal.drug.modal.document.remove_file')}}",
                type: 'POST',
                data: {
                    id: $id,
                    field: 'template_id',
                },
                success: function () {
                    $e.target.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="template_file"/>'
                }
            });
        }

        function removeResource($id, $e) {
            $.ajax({
                url: "{{route('eac.portal.drug.modal.resource.remove_file')}}",
                type: 'POST',
                data: {
                    id: $id,
                    field: 'template_id',
                },
                success: function () {
                    $e.target.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="file_id"/>'
                }
            });
        }

        tinymce.init({
            selector: '.editor'
        });
        $('.select-all').click(function () {
            let selectID = $(this).attr('for');
            let select = $('#' + selectID);
            select.find('option').prop('selected', true);
        });

        $('input.auto_update').each(function () {
            $(this).change(function () {
                let row = {'id': $('.auto_update').attr("data-id")};
                let e = $(this);
                if ($(this).is(':checkbox')) {
                    row[$(this).attr("name")] = $(this).is(':checked') ? '1' : '0';
                } else {
                    row[$(this).attr("name")] = $(this).val();
                }
                $.ajax({

                    url: "{{route('eac.portal.drug.edit.save')}}",
                    type: 'POST',
                    data: {
                        'save_data': row,
                    },
                    success: function (response) {
                        if (response['result'] === 'success') {
                            e.animate({backgroundColor: "green"}, "slow").delay(2500).animate({backgroundColor: "white"});
                        } else {
                            e.animate({backgroundColor: "red"}, "slow").delay(2500).animate({backgroundColor: "white"});
                        }
                    }
                });
            });
        });

        $('textarea.auto_update').each(function () {
            $(this).change(function () {
                let row = {'id': $('.auto_update').attr("data-id")};
                let e = $(this);
                row[$(this).attr("name")] = $(this).val();
                $.ajax({

                    url: "{{route('eac.portal.drug.edit.save')}}",
                    type: 'POST',
                    data: {
                        'save_data': row,
                    },
                    success: function (response) {
                        if (response['result'] === 'success') {
                            e.animate({backgroundColor: "green"}, "slow").delay(2500).animate({backgroundColor: "white"});
                        } else {
                            e.animate({backgroundColor: "red"}, "slow").delay(2500).animate({backgroundColor: "white"});
                        }
                    }
                });
            });
        });

        $('select.auto_update').each(function () {
            $(this).change(function () {
                let row = {'id': $('.auto_update').attr("data-id")};
                let e = $(this);
                if ($(this).is('.select2')) {
                    row[$(this).attr("name")] = JSON.stringify($(this).val());
                } else {
                    row[$(this).attr("name")] = $(this).val();
                }
                $.ajax({

                    url: "{{route('eac.portal.drug.edit.save')}}",
                    type: 'POST',
                    data: {
                        'save_data': row,
                    },
                    success: function (response) {
                        if (response['result'] === 'success') {
                            e.animate({backgroundColor: "green"}, "slow").delay(2500).animate({backgroundColor: "white"});
                        } else {
                            e.animate({backgroundColor: "red"}, "slow").delay(2500).animate({backgroundColor: "white"});
                        }
                    }
                });
            });
        });
        // generate document by changing select type dropdown
        $('.type_id').change(function () {
            var data = "";
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{route('eac.portal.drug.documentTypeTemplate')}}",
                data: {
                    'id': id
                },
                async: false,
                beforeSend: function () {
                    swal({
                        title: "",
                        text: "wait..",
                        showConfirmButton: false
                    });
                },
                success: function (response) {
                    $('#upload_file_ajax').html('');
                    setTimeout(function () {
                        swal.close();
                    }, 50);

                    $('#upload_file_ajax').html(response.html);
                },
                error: function (xhr, status, errorThrown) {
                    xhr.status;

//The message added to Response object in Controller can be retrieved as following.
                    xhr.responseText;
                    if (xhr.status === 0) {
                        alert('Not connected.\nPlease verify your network connection.');
                    } else if (xhr.status == 404) {
                        alert('The requested page not found. [404]');
                    } else if (xhr.status == 500) {
                        alert('Internal Server Error [500].');
                    } else if (exception === 'parsererror') {
                        alert('Requested JSON parse failed.');
                    } else if (exception === 'timeout') {
                        alert('Time out error.');
                    } else if (exception === 'abort') {
                        alert('Ajax request aborted.');
                    } else {
                        alert('Uncaught Error.\n' + xhr.responseText);
                    }
                }
            });

        });
        $(".alert").delay(7000).slideUp(200, function () {
            $(this).alert('close');
        });
	</script>
	@if(isset($sweet_alert))
		<script>
			{{ $sweet_alert}}
		</script>
	@endif
	@if(old('modal_id'))
		<script>
            $(window).on('load', function () {
                $("#{{ old('modal_id') }}").modal('show');
            });
            $(".cancel").click(function () {
                console.log('reset data');
// $('.newdosageModal')[0].reset();

                $('input').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                $('.newdosageModal')[0].reset();

            });
		</script>
	@endif
	
	
	<script type="text/javascript">

        function Confirm_Delete(param) {
            console.log(param);

            swal({
                title: "Delete Unused Component",
                text: "You're about to delete this component, are you sure?",
                icon: "warning",
                buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                ],
                dangerMode: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Success!',
                        text: 'Content deleted!',
                        icon: 'success'
                    }).then(function () {
                        $.get("{{route('eac.portal.drug.component.delete')}}",
                            {
                                id: param
                            });
// return false;
                        swal.close();

                        location.reload(true);
                    });
                } else {
                    swal("Cancelled", "Operation cancelled", "error");
                }
            })
        }

        function Delete_Dosage(param) {
            console.log(param);

            swal({
                title: "Delete Unused Dosage",
                text: "You're about to delete this dosage, are you sure?",
                icon: "warning",
                buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                ],
                dangerMode: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Success!',
                        text: 'Content deleted!',
                        icon: 'success'
                    }).then(function () {
                        $.get("{{route('eac.portal.drug.component.dosage.remove')}}",
                            {
                                id: param
                            });
// return false;
                        swal.close();

                        location.reload(true);
                    });
                } else {
                    swal("Cancelled", "Operation cancelled", "error");
                }
            })
        }

        function addMember() {
            let $template = $('.group-member-template');
            let $memberSection = $("#memberSection");
            console.log($template);
            $memberSection.append($template.prop('outerHTML'));
            let $newMember = $memberSection.find(".group-member:last");
            $newMember.removeClass('group-member-template');
            const $count = $memberSection.find(".group-member").length - 1;
            $newMember.find('select[name^="member"]').attr('name', 'member[' + $count + ']');
            $newMember.find('select[name^="role"]').attr('name', 'role[' + $count + ']');
        }
	</script>
@append
