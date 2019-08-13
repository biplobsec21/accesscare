@extends('layouts.portal')

@section('title')
	Dashboard
@endsection

@section('content')
 <p class="lead">
  Welcome to your <strong>Dashboard</strong>
 </p>
 @if(\Auth::user()->type->name != 'Early Access Care')
  @if(\Auth::user()->type->name == 'Physician')
   <div class="row">
    <div class="col-md-7 col-lg-8 border border-danger">
     <div class="row">
      <div class="col-sm-6 col-md-12 col-lg-6">
       <div class="card card-body p-3">
        @if(!$rids->count())
         <h5 class="text-center mb-3">You have not submitted any <strong>RIDs</strong></h5>
         <p class="small ml-2 mr-2 text-center">"Initiate Request" initiates a drug order for investigational drug. You will receive an email with a unique Request ID number (RID).</p>
         <p class="text-center mb-0">
          <a href="{{ route('eac.portal.rid.create') }}" class="btn btn-success">Initiate Request</a>
         </p>
        @else
         <p>View <a href="{{route('eac.portal.rid.list')}}" class="">{{ $rids->count()}}</a> requests</p>
        @endif
       </div>
      </div>
     </div><!-- /.row -->
    </div>
    <div class="col-md border border-info">
     <ul class="list-group">
      <li class="list-group-item">
       <small class="d-block upper">
        Created/Added
       </small>
      </li>
      <li class="list-group-item">
       <small class="d-block upper">
        Location
       </small>
      </li>
      <li class="list-group-item">
       <small class="d-block upper">
        Last Login
       </small>
      </li>
     </ul>
    </div>
   </div>
  @elseif(\Auth::user()->type->name == 'Pharmaceutical')
  @endif
 @else
  EAC user
 @endif


  @if(\Auth::user()->hasDefaultPassword())
   <a href="{{ route('eac.portal.user.create') }}" class="btn btn-primary">
    <i class="fa-fw fas fa-lock"></i> Set Your Password
   </a>
   <hr />
  @endif
  @if(\Auth::user()->type->name != 'Early Access Care')
   <div class="row">
    @if((!$rids->count()) && (!$drugs->count()) && (!$users->count()))
     @if(\Auth::user()->type->name == 'Pharmaceutical')
      <div class="col-sm-6 col-lg-4">
       <div class="card card-body p-3">
        @if(!$drugs->count())
         <h5 class="text-center mb-3">You have not entered any <strong>Drugs</strong></h5>
         <p class="text-center mb-0">
          <a href="{{ route('eac.portal.drug.create') }}" class="btn btn-success">Add Drug</a>
         </p>
        @else
         <p>View <a href="{{route('eac.portal.drug.list')}}" class="">{{ $drugs->count() }}</a> drugs</p>
        @endif
       </div>
      </div>
      <div class="col-sm-6 col-lg-4">
       <div class="card card-body p-3">
        @if(!$users->count())
         <h5 class="text-center mb-3">You have not added any <strong>Users</strong></h5>
         <p class="text-center mb-0">
          <a href="{{ route('eac.portal.user.create') }}" class="btn btn-success">Add User</a>
         </p>
        @else
         <p>View <a href="{{route('eac.portal.user.list')}}" class="">{{ $users->count() }}</a> drugs</p>
        @endif
       </div>
      </div>
     @endif
    @endif
   </div>
  @endif

 <div class="viewData">
		<div class="gradients">
			<div class="row">
				@if($rids->count())
					<div class="col-sm mr-xl-4 mb-5">
						<div class="card m-0 h-100 dcounter">
							<div class="card-body p-2">
								<div class="row align-items-center">
									<div class="col">
										<h5 class="text-primary strong text-upper m-0">
											Requests
										</h5>
									</div>
									<div class="pl-0 col-auto">
										<a href="{{route('eac.portal.rid.list')}}" class="btn p-0">
											<div
												class="gradient circle d-flex align-items-center justify-content-center">
												<h3 class="m-0">{{ $rids->count()}}</h3>
											</div>
										</a>
									</div>
								</div>
								<ul class="list-group list-group-flush mb-0 mt-1">
									@foreach(\App\RidMasterStatus::all() as $status)
										<li class="list-group-item small pl-2 pb-0 pr-2 pt-0 @if($status->name == 'New')text-danger @endif">
											<a href="{{route('eac.portal.rid.list','rid_status=' . $status->id)}}">
												<div class="row m-0">
													<div class="col p-0">
														{{ $status->name }}
														@if($status->name == 'New')
															<i class="fas fa-exclamation-triangle text-danger"></i>
														@endif
													</div>
													<div class="col-auto p-0">
														<span
															class="badge @if($status->name == 'New') badge-danger @else badge-light @endif">
															{{ $rids->where('status_id', $status->id)->count() }}
														</span>
													</div>
												</div><!-- /.row -->
											</a>
										</li>
									@endforeach
								</ul>
							</div>
							<a href="{{ route('eac.portal.rid.create') }}" class="btn btn-primary btn-block">
								<i class="fa-fw fas fa-medkit"></i> Initiate Request
							</a>
						</div><!-- /.card -->
					</div>
				@endif
				@if($drugs->count())
					<div class="col-sm ml-xl-4 mr-xl-4 mb-5">
						<div class="card m-0 h-100 dcounter">
							<div class="card-body p-2">
								<div class="row align-items-center">
									<div class="col">
										<h5 class="text-primary strong text-upper m-0">
											Drugs
										</h5>
									</div>
									<div class="pl-0 col-auto">
										<a href="{{route('eac.portal.drug.list')}}" class="btn p-0">
											<div
												class="gradient circle d-flex align-items-center justify-content-center">
												<h3 class="m-0">{{ $drugs->count() }}</h3>
												@php
													$approved = $drugs->where('status','Approved')->count();
													$notApproved = $drugs->where('status','Not Approved')->count();
													$pending = $drugs->where('status','Pending')->count();
												@endphp
											</div>
										</a>
									</div>
								</div>
								<ul class="list-group list-group-flush mb-0 mt-1">
									<li class="list-group-item small pl-2 pb-0 pr-2 pt-0 @if($pending > 0) text-danger @endif">
										<a href="{{route('eac.portal.drug.list','drug_status='.'Pending')}}"
										   class="text-danger">
											<div class="row m-0">
												<div class="col p-0">
													Pending
													@if($pending > 0)
														<i class="fas fa-exclamation-triangle text-danger"></i>
													@endif
												</div>
												<div class="col-auto p-0">
													<span class="badge @if($pending > 0) badge-danger @else badge-light @endif">
														@if($pending > 0)
															{{$pending}}
														@else
															0
														@endif
													</span>
												</div>
											</div><!-- /.row -->
										</a>
									</li>
									<li class="list-group-item small pl-2 pb-0 pr-2 pt-0">
										<a href="{{route('eac.portal.drug.list','drug_status='.'Approved')}}">
											<div class="row m-0">
												<div class="col p-0">
													Approved
												</div>
												<div class="col-auto p-0">
													<span class="badge badge-light">
														@if($approved > 0)
															{{$approved}}
														@else
															0
														@endif
													</span>
												</div>
											</div><!-- /.row -->
										</a>
									</li>
									<li class="list-group-item small pl-2 pb-0 pr-2 pt-0">
										<a href="{{route('eac.portal.drug.list','drug_status='.'Not Approved')}}">
											<div class="row m-0">
												<div class="col p-0">
													Not Approved
												</div>
												<div class="col-auto p-0">
													<span class="badge badge-light">
														@if($notApproved > 0)
															{{$notApproved}}
														@else
															0
														@endif
													</span>
												</div>
											</div><!-- /.row -->
										</a>
									</li>
								</ul>
							</div>
							<a href="{{ route('eac.portal.drug.create') }}" class="btn btn-primary btn-block">
								<i class="fa-fw fas fa-prescription-bottle-alt"></i> Add Drug
							</a>
						</div><!-- /.card -->
					</div>
				@endif
				@if($users->count())
					<div class="col-sm ml-xl-4 mb-5">
						<div class="card m-0 h-100 dcounter">
							<div class="card-body p-2">
								<div class="row align-items-center">
									<div class="col">
										<h5 class="text-primary strong text-upper m-0">
											Users
										</h5>
									</div>
									<div class="pl-0 col-auto">
										<a href="{{route('eac.portal.user.list')}}" class="btn p-0">
											<div
												class="gradient circle d-flex align-items-center justify-content-center">
												<h3 class="m-0">{{ $users->count() }}</h3>
											</div>
										</a>
									</div>
								</div>
								<ul class="list-group list-group-flush mb-0 mt-1">
									<li class="list-group-item small pl-2 pb-0 pr-2 pt-0 text-danger">
										<a href="{{route('eac.portal.user.list','user_status='.'Pending')}}"
										   class="text-danger">
											<div class="row m-0">
												<div class="col p-0">
													Pending
													<i class="fas fa-exclamation-triangle text-danger"></i>
												</div>
												<div class="col-auto p-0">
													@php $pending_user = $users->where('status','Pending')->count(); @endphp
													<span class="badge badge-danger">
														@if($pending_user > 0)
															{{$pending_user}}
														@else
															0
														@endif
													</span>
												</div>
											</div><!-- /.row -->
										</a>
									</li>
									<li class="list-group-item small pl-2 pb-0 pr-2 pt-0">
										<a data-toggle="collapse" href="#showUsers" role="button" aria-expanded="true"
										   aria-controls="showUsers">
											<div class="row m-0">
												<div class="col p-0">
													Approved
												</div>
												<div class="col-auto p-0">
													<i class="far fa-chevron-down"></i>
												</div>
											</div><!-- /.row -->
										</a>
										<div class="collapse show" id="showUsers">
											<ul class="list-unstyled m-0">
												@php
													$approved_users = collect($users->where('status','Approved')->groupBy(function ($user) {
														return json_encode($user->type);
													})->all());
												@endphp
												@if($approved_users->count() > 0)
													@foreach($approved_users as $type => $user)
														<li class="pt-0 pr-0 pl-3 pl-xl-4 pb-1">
															<a href="{{route('eac.portal.user.list','user_status='.'Approved&user_type='. json_decode($type)->id)}}">
																<div class="row m-0">
																	<div class="col p-0">
																		{{ json_decode($type)->name }} Users
																	</div>
																	<div class="col-auto p-0">
																		<span class="badge badge-light">
																			{{ $user->count() }}
																		</span>
																	</div>
																</div><!-- /.row -->
															</a>
														</li>
													@endforeach
												@endif
											</ul>
										</div>
									</li>
									<li class="list-group-item small pl-2 pb-0 pr-2 pt-0">
										<a href="{{route('eac.portal.user.list','user_status='.'Suspended')}}">
											<div class="row m-0">
												<div class="col p-0">
													Suspended
												</div>
												<div class="col-auto p-0">
													@php $suspended_user = $users->where('status','Suspended')->count(); @endphp
													<span class="badge badge-light">
														@if($suspended_user > 0)
															{{$suspended_user}}
														@else
															0
														@endif
													</span>
												</div>
											</div><!-- /.row -->
										</a>
									</li>
								</ul>

							</div>
							<a href="{{ route('eac.portal.user.create') }}" class="btn btn-primary btn-block">
								<i class="fa-fw fas fa-user-md"></i> Add User
							</a>
						</div><!-- /.card -->
					</div>
				@endif
			</div>
		</div>
		@if(\Auth::user()->type->name == 'Early Access Care')
			<div class="card mb-5">
				<div class="card-body pt-3 pl-3 pr-3 pb-0">
					<h5 class="text-primary strong text-upper mb-3">
						Requests Pending Fulfillment
					</h5>
				</div>
				<div class="table-responsive">
					<table class="table table-sm table-striped table-hover" id="ridAwaitingListTBL">
						<thead>
						<tr>
							<th class="no-search no-sort"></th>
							<th>RID Number</th>
							<th>Drug Requested</th>
							<th>Ship By</th>
							<th class="no-search no-sort"></th>
						</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		@endif
	</div><!-- end .viewData -->
@endsection
@section('scripts')
	<script>
		//Rid Shipment Table
		$(document).ready(function () {
			/**
			 * ridShipFormat
			 * @param {object} $d - original data object for the row
			 * @returns {string} newly formatted row
			 */
			function ridShipFormat($d) {
				return '<table>' +
					'<tr>' +
					'<td>Delivery Date:</td>' +
					'<td>' + $d.delivery_date + '</td>' +
					'</tr>' +
					'<tr>' +
					'<td>Destination:</td>' +
					'<td>' + $d.destination + '</td>' +
					'</tr>' +
					'</table>';
			}

			var dataTable5 = $('#ridAwaitingListTBL').DataTable({
				columnDefs: [{
					targets: 'no-sort',
					orderable: false,
				}],
				"paginationDefault": 10,
				"paginationOptions": [10, 25, 50, 75, 100],
				// "responsive": true,
				'order': [[3, 'asc']],
				"ajax": {
					url: "{{route('eac.portal.rid.ajax.ridawaitinglist')}}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{
						"className": 'details-control',
						"orderable": false,
						"data": null,
						"defaultContent": '<i class="fas fa-plus"></i>'
					},
					{"data": "number"},
					{"data": "drug_name"},
					{"data": "ship_by_date"},
					{"data": "ops_btns"},

				]
			});
			dataTable5.columns().every(function () {
				var that = this;
				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that
							.search(this.value)
							.draw();
					}
				});
			});
			dataTable5.columns().every(function () {
				var that = this;
				$('input', this.footer()).on('keyup change', function () {
					if (that.search() !== this.value) {
						that.search(this.value).draw();
					}
				});
			});
			$('#ridAwaitingListTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search")) {
					$(this).text("");
				} else {
					$(this).html('<input type="text" class="form-control" placeholder="Search ' + $(this).text() + '"/>');
				}
			});
			$('#ridAwaitingListTBL tbody').on('click', 'td.details-control', function () {
				var tr = $(this).closest('tr');
				var row = dataTable5.row(tr);

				if (row.child.isShown()) {
					// This row is already open - close it
					row.child.hide();
					tr.removeClass('shown');
				} else {
					// Open this row
					row.child(ridShipFormat(row.data())).show();
					tr.addClass('shown');
				}
			});
		});

		// Recent Activity List
		$(document).ready(function () {
			$('#recentActivityList tfoot th').each(function () {
				if ($(this).hasClass("no-search")) {
					$(this).text("");
					return;
				}
				var title2 = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title2 + '"/>');
			});
			var dataTable6 = $('#recentActivityList').DataTable({

				fnDrawCallback: function () {
					jQuery("input[data-toggle='toggle']").bootstrapToggle();
				},
				"paginationDefault": 10,
				"paginationOptions": [10, 25, 50, 75, 100],
				"responsive": false,
				"searching": false,
				'order': [[0, 'desc']],
				"ajax": {
					url: "{{route('eac.portal.dashboard.ajax.ajaxrecentactivity')}}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{"data": "date", "name": "date"},
					{"data": "item", "name": "item"},
					{"data": "status", "name": "status"},
					{"data": "type", "name": "type"},
					{"data": "activity", "name": "activity"},
					{"data": "ops_btns"}
				]
			});
		});
	</script>


	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endsection
