@extends('layouts.portal')
@section('title')
	Edit Details
@endsection

@section('styles')
	<style>
		h1 .badge, h2 .badge, h3 .badge, h4 .badge {
			font-size: 14px;
			line-height: 18px;
		}
		
		@media screen and (min-width: 1200px) {
			:root {
				--leftCol: 220px;
				--rightCol: 700px;
			}
			
			.actionBar {
				max-width: calc(var(--leftCol) + var(--rightCol));
			}
			
			.viewData .row.thisone > [class*=col]:first-child {
				width: var(--leftCol);
			}
			
			.viewData .row.thisone > [class*=col]:last-child {
				width: var(--rightCol);
			}
		}
		
		@media screen and (min-width: 1300px) {
			:root {
				--rightCol: 800px;
			}
		}
	</style>
	
	<style>
		.input-group-div {
			font-size: .95em;
			line-height: inherit;
			height: calc(1.5em + 10px);
			padding: .15rem .75rem .15rem .35rem;
			margin-bottom: 0;
			margin-right: -1px;
			text-align: center;
			align-items: center;
			white-space: nowrap;
			border: 1px solid #ced4da;
		}
		
		.col-half {
			flex-basis: 0;
			flex-grow: 0.5;
			position: relative;
			width: 100%;
		}
		
		.cheats.list-group-flush:first-child .list-group-item:first-child {
			padding-top: 0;
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
							<a href="{{ route('eac.portal.rid.list') }}">All RIDs</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route("eac.portal.rid.show", $rid->id) }}">{{$rid->number}}</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							@yield('title')
						</li>
					</ol>
				</div>
				<div class="col-sm-auto ml-sm-auto d-none d-sm-block">
					<div class="small">
						<strong>Last Updated:</strong>
						@php
							$time = $rid->updated_at;
							echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
						@endphp
					</div>
				</div>
			</div>
		</nav>
		<h6 class="small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{$rid->number}}
		</h2>
	</div><!-- end .titleBar -->
	
	<div class="actionBar">
		<a href="{{ route("eac.portal.rid.show", $rid->id) }}" class="btn btn-secondary">
			<i class="fal fa-angle-double-left"></i>
			View RID
		</a>
		<div class="btn-group" role="group">
			<button id="btnGroupDrop3" type="button" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Change Status
				<i class="fa-fw fas fa-caret-down"></i>
			</button>
			<div class="dropdown-menu" aria-labelledby="btnGroupDrop3">
				@foreach(\App\RidMasterStatus::all() as $masterStatus)
					<a class="dropdown-item" href="{{route('eac.portal.rid.changestatus', ['rid_id' => $rid->id,'status' => $masterStatus->id])}}">{{ $masterStatus->name}}</a>
				@endforeach
			
			</div>
		</div>
	</div><!-- end .actionBar -->
	@if(Session::has('alerts'))
		{!! view('layouts.alert-dismiss', ['type' => Session::get('alerts')['type'], 'message' => Session::get('alerts')['msg']]) !!}
	@endif
	<div class="viewData" style="max-width: calc(var(--leftCol) + var(--rightCol))">
		<div class="row thisone m-0 mb-xl-5">
			<div class="col-sm-3 col-xl-auto p-0 pr-sm-2 mb-2 mb-sm-0">
				<div class="wizardSteps symbols nav flex-row flex-sm-column" id="tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link active complete " id="xpatientT-tab" data-toggle="pill" href="#xpatientT" role="tab" aria-controls="xpatientT" aria-selected="true">
						<span>Patient Information</span>
					</a>
					<a class="nav-link complete" id="xdrugT-tab" data-toggle="pill" href="#xdrugT" role="tab" aria-controls="xdrugT" aria-selected="false">
						<span>Drug Information</span>
					</a>
					<a class="nav-link complete" id="xusergrpT-tab" data-toggle="pill" href="#xusergrpT" role="tab" aria-controls="xusergrpT" aria-selected="false">
						<span>User Groups</span>
					</a>
					<a class="nav-link  @if($rid->notes->count() > 0) complete @endif " id="xnotesT" data-toggle="pill" href="#xnotes" role="tab" aria-controls="xnotes" aria-selected="false">
						<span>Rid Notes</span>
					</a>
				</div>
			</div>
			<div class="col-sm-9 col-xl p-0 pl-sm-2">
				<div class="card tab-content wizardContent" id="tabContent">
					<div class="auto-update">
						@access('rid.info.update')
						@include('portal.rid.edit.info')
						@endif
					</div>
					<div class="tab-pane fade show active" id="xpatientT" role="tabpanel" aria-labelledby="xpatientT-tab">
						<div class="card-body  auto-update">
							@access('rid.patient.update')
							@include('portal.rid.edit.patient')
							@endif
						</div>
					</div><!-- /.tab-pane -->
					
					<div class="tab-pane fade" id="xdrugT" role="tabpanel" aria-labelledby="xdrugT-tab">
						<div class="card-body  auto-update">
							@access('rid.drug.update')
							@include('portal.rid.edit.drug')
							@endif
						</div>
					</div><!-- /.tab-pane -->
					
					<div class="tab-pane fade" id="xusergrpT" role="tabpanel" aria-labelledby="xusergrpT-tab">
						<div class="card-body">
							@access('rid.user.update')
							@include('portal.rid.edit.users')
							@endif
						</div>
						@access('rid.user.update')
						<div class="card-footer text-right p-3">
							<button type="button" class="btn btn-success window-btn" data-toggle="modal" data-target="#addRidTeam">
								Assign User Group
							</button>
						</div>
						@include('include.portal.modals.rid.group.add')
						@endif
					</div><!-- /.tab-pane -->
					<div class="tab-pane fade" id="xnotes" role="tabpanel" aria-labelledby="xnotes-tab">
						<div class="card-body">
							@access('rid.note.view')
							<h5 class="text-gold mb-2">
								Notes &amp; Correspondence
								<span class="badge badge-dark">{{$rid->notes->count()}}</span>
							</h5>
							<div class="row">
								<div class="col">
									<ul class="list-group list-group-flush m-0">
										@if($rid->notes->count())
											@foreach($rid->notes->sortByDesc('created_at') as $note)
												<li class="list-group-item pt-2 pl-0 pr-0 pb-2">
													<a href="{{ route('eac.portal.note.delete', $note->id) }}" class="btn text-danger float-right" title="Delete Note">
														<i class="far fa-times"></i>
														<span class="sr-only">Delete</span>
													</a>
													<label class="d-block">
														{{ $note->author->full_name }}
														<small>{{ $note->created_at->format('Y-m-d h:m A') }}</small>
													</label>
													<p class="m-0">{{ $note->text }}</p>
												</li>
											@endforeach
										@else
											<p class="text-muted mb-0">
												<i class="fal fa-info-circle"></i>
												No information available
											</p>
										@endif
									</ul>
								</div>
								<div class="col-auto">
									@access('rid.note.create')
									<a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#RidNoteAdd">
										Add Note
									</a>
									@endif
								</div>
							</div><!-- /.row -->
							@endif
							<div class="modal fade" id="RidNoteAdd" tabindex="-1" role="dialog" aria-hidden="true">
								<form method="post" action="{{ route('eac.portal.note.create') }}">
									{{ csrf_field() }}
									<input type="hidden" name="subject_id" value="{{$rid->id}}">
									<div class="modal-dialog modal-dialog-centered " role="document">
										<div class="modal-content">
											<div class="modal-header p-2">
												<h5 class="m-0">
													Add Note to
													<strong>RID: {{ $rid->number }}</strong>
												</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<i class="fal fa-times"></i>
												</button>
											</div>
											<div class="modal-body p-3">
												@if(\Auth::user()->type->name == 'Early Access Care')
													<label class="d-block">
														<input name="physican_viewable" type="checkbox" value="1" /> Viewable by Physician
													</label>
												@else
													<input name="physican_viewable" type="hidden" value="1" />
												@endif
												<label class="d-block">
													{{ \Auth::user()->first_name }}
													{{ \Auth::user()->last_name }}
													<small>{{date('Y-m-d H:i')}}</small>
												</label>
												<textarea name="text" class="note_text form-control" rows="3" placeholder="Enter note..."></textarea>
											</div>
											<div class="modal-footer p-2 d-flex justify-content-between">
												<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel
												</button>
												<button type="submit" name="submit" class="btn btn-success" value="Add Note">Submit
												</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					@if(true)
						<div class="bg-gradient-dark p-3 d-flex justify-content-between">
							<a class="btn btn-danger" title="Deny Rid" href="{{route('eac.portal.rid.deny', $rid->id)}}">
								<i class="fas d-sm-inline fa-ban"></i>
								Not Approved
							</a>
							<a class="btn btn-primary mr-3" title="More Information Needed" href="#">
								<i class="fas d-sm-inline fa-exclamation-triangle"></i>
								More Info
								<span class="d-sm-inline">rmation</span>
								Needed
							</a>
							<a class="btn btn-success" title="Approve Rid" href="{{route('eac.portal.rid.approve', $rid->id)}}">
								<i class="fas d-sm-inline fa-check"></i>
								Approve Request
							</a>
						</div>
					@endif
				</div>
			</div>
		
		</div>
	</div>
	@include('include.portal.modals.rid.patient.dob')
	<input type="hidden" id="key" value="{{ $rid->id }}"/>
@endsection

@section('scripts')
	<script>
        $(document).ready(function () {
            $('.auto-update select').change(function () {
                let e = $(this);
                $.ajax({
                    method: "POST",
                    url: "{{ route('eac.portal.rid.store.auto') }}",
                    data: {name: $(this).attr('name'), value: $(this).val(), key: $('#key').val()},
                    success: function (response) {
                        e.animate({backgroundColor: '#88c442'}, 'slow').delay(2500).animate({backgroundColor: 'white'});
                    },
                    error: function (response) {
                        alert('error ' + response);
                    }
                });
            });
            $('.auto-update .select2').change(function () {
// console.log($(this).next().find('.select2-selection__rendered' ) );
                let e = $(this).next().find('.select2-selection__rendered');
                $.ajax({
                    method: "POST",
                    url: "{{ route('eac.portal.rid.store.auto') }}",
                    data: {name: $(this).attr('name'), value: $(this).val(), key: $('#key').val()},
                    success: function (response) {
                        e.animate({backgroundColor: '#88c442 !important'}, 'slow').delay(2500).animate({backgroundColor: 'white'});
                    },
                    error: function (response) {
                        alert('error ' + response);
                    }
                });
            });
            $('.auto-update input').blur(function () {
                let e = $(this);
                $.ajax({
                    method: "POST",
                    url: "{{ route('eac.portal.rid.store.auto') }}",
                    data: {name: $(this).attr('name'), value: $(this).val(), key: $('#key').val()},
                    success: function (response) {
                        e.animate({backgroundColor: '#88c442'}, 'slow').delay(2500).animate({backgroundColor: 'white'});
                    },
                    error: function (response) {
                        alert('error ' + response);
                    }
                });
            });
            $('.auto-update textarea').change(function () {
                let e = $(this);
                $.ajax({
                    method: "POST",
                    url: "{{ route('eac.portal.rid.store.auto') }}",
                    data: {name: $(this).attr('name'), value: $(this).val(), key: $('#key').val()},
                    success: function (response) {
                        e.animate({backgroundColor: '#88c442'}, 'slow').delay(2500).animate({backgroundColor: 'white'});
                    },
                    error: function (response) {
                        alert('error ' + response);
                    }
                });
            });
        });
	</script>
@endsection
