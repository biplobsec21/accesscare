@extends('layouts.portal')

@section('title')
	View Company
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
       <a href="{{ route('eac.portal.company.list') }}">All Companies</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
       View Company: {{ $company->name }}
      </li>
     </ol>
    </div>
    <div class="d-none d-sm-block col-sm-auto ml-sm-auto">
     <div class="small">
      @if(!is_null(Auth::user()->last_seen))
       <strong>Last Updated:</strong>
       @php
        $time = $user->updated_at;
        
        echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
       @endphp
      @endif
     </div>
    </div>
   </div>
  </nav>
  <h5 class="m-0">
   @yield('title')
  </h5>
  <h2 class="m-0">
   {{ $company->name }} ({{ $company->abbr }})
  </h2>
  <div class="small d-sm-none">
   @if(!is_null(Auth::user()->last_seen))
    <strong>Last Updated:</strong>
    @php
     $time = $user->updated_at;
     
     echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
    @endphp
   @endif
  </div>
 </div><!-- end .titleBar -->

 <div class="actionBar">
  <a href="{{ url()->previous() }}" class="btn btn-light">
   <i class="fal fa-angle-double-left"></i> Go Back
  </a>
  <a href="{{ route('eac.portal.company.list') }}" class="btn btn-primary">
   <i class="fal fa-hospitals"></i> All Companies
  </a>
  <a href="{{ route('eac.portal.company.edit', $company->id) }}" class="btn btn-danger">
   <i class="fal fa-edit"></i> Edit Company
  </a>
 </div><!-- end .actionBar -->

	<div class="viewData">
  <h5>
   Company Information
  </h5>
  <div class="card card-body mb-3 mb-xl-4">
   <div class="row">
    <div class="col-lg mb-3 mb-lg-0">
     <label class="d-block">Status</label>
     <span class="badge badge-">{{ $company->status }}</span>
    </div>
    <div class="col-auto col-sm">
      <label class="d-block">Company Name</label>
      {{ $company->name }}
     <small>({{ $company->abbr }})</small>
    </div>
    <div class="col-auto col-sm mb-0">
    </div>
   </div>
  </div>
		<div class="row">
			<div class="col-md-4 col-xl-3">
    <h5>
     Company Details
    </h5>
    <div class="card card-body mb-3 mb-xl-4">
     <div class="mb-3">
      <label class="d-block">Company Name</label>
      {{ $company->name }}
     </div>
     <div class="mb-3">
      <label class="d-block">Abbreviation</label>
      {{ $company->abbr }}
     </div>
     <div class="mb-3">
      <label class="d-block">Company Website</label>
      @if($company->site){{ $company->site }}@else
       <small class="text-muted">N/A</small>
      @endif
     </div>
     <div class="">
      <label class="d-block">Address</label>
      @if(isset($company->address))
       {{ $company->address->addr1 }}
       @if(isset($company->address->addr2))
        , {{ $company->address->addr2 }}
       @endif
       <br />
       {{ $company->address->city }}
       , @if($company->address->state){{  $company->address->state->abbr }}@endif {{ $company->address->zipcode }}
       <br/>
       {{ $company->address->country->name }}
      @else
       No Address data.
      @endif
     </div>
    </div>
			</div>
			<div class="col-md-8 col-xl-auto">
    <div class="added-styling">
     <ul class="nav nav-tabs" id="dashTabsV2" role="tablist">
      <li class="nav-item">
       <a class="nav-link active" id="deptmain-tab" data-toggle="tab" href="#deptmain" role="tab" aria-controls="deptmain" aria-selected="true">
        Contact Information
       </a>
      </li>
      @foreach($company->departments as $department)
       <li class="nav-item">
        <a class="nav-link" id="dept{{$department->id}}-tab" data-toggle="tab" href="#dept{{$department->id}}" role="tab" aria-controls="dept{{$department->id}}" aria-selected="false">
         {{ $department->name }} Dept
        </a>
       </li>
      @endforeach
     </ul>
    </div>
    <div class="card card-body mb-3 mb-xl-4 tab-content" id="dashTabsV2Content">
     <div class="tab-pane fade show active" id="deptmain" role="tabpanel" aria-labelledby="deptmain-tab">
      <div class="mb-3">
       <label class="d-block">Phone Number</label>
       @if($company->phone_main){{ $company->phone_main }}@else
        <small class="text-muted">N/A</small>
       @endif
      </div>
      <div class="">
       <label class="d-block">Email Address</label>
       @if($company->email_main){{ $company->email_main }}@else
        <small class="text-muted">N/A</small>
       @endif
      </div>
     </div>
     @foreach($company->departments as $department)
      <div class="tab-pane fade" id="dept{{$department->id}}" role="tabpanel" aria-labelledby="dept{{$department->id}}-tab">
       <ul class="list-group list-group-flush">
        @if($department->phone_id)
         <li class="list-group-item">
          <label class="d-block">Phone</label>
          {{ $department->phone->number }}
         </li>
        @endif
        @if($department->email)
         <li class="list-group-item">
          <label class="d-block">Email</label>
          {{ $department->email }}
         </li>
        @endif
       </ul>
      </div>
     @endforeach
    </div>
			</div>
		</div>
  <div class="added-styling">
   <ul class="nav nav-tabs" id="dashTabsV2" role="tablist">
    <li class="nav-item">
     <a class="nav-link active" id="PharmaDrugs-tab" data-toggle="tab" href="#PharmaDrugs" role="tab" aria-controls="PharmaDrugs" aria-selected="true">
      Submitted Drugs
      <span class="badge badge-primary">{{ $company->drugs->count() }}</span>
     </a>
    </li>
    <li class="nav-item">
     <a class="nav-link" id="PharmaRIDS-tab" data-toggle="tab" href="#PharmaRIDS" role="tab" aria-controls="PharmaRIDS" aria-selected="false">
      Assigned RIDs
      <span class="badge badge-primary">{{ $company->rids->count() }}</span>
     </a>
    </li>
    <li class="nav-item">
     <a class="nav-link" id="PharmaUsers-tab" data-toggle="tab" href="#PharmaUsers" role="tab" aria-controls="PharmaUsers" aria-selected="false">
      Associated Users
      <span class="badge badge-primary">{{ $company->users->count() }}</span>
     </a>
    </li>
   </ul>
  </div>
  <div class="card mb-1 mb-md-4 tab-content" id="dashTabsV2Content">
   <div class="tab-pane fade show active" id="PharmaDrugs" role="tabpanel" aria-labelledby="PharmaDrugs-tab">
    <div id="selectors"></div>
    <div id="results">
     <div class="table-responsive">
      <table class="table table-striped table-hover" id="companyDrugListTBL">
       <thead>
       <tr>
        <th>Drug Name</th>
        <th>Company</th>
        <th>Status</th>
        <th>Submitted Date</th>
        <th></th>
       </tr>
       </thead>
       <tbody></tbody>
      </table>
     </div>
    </div>
   </div>
   <div class="tab-pane fade" id="PharmaRIDS" role="tabpanel" aria-labelledby="PharmaRIDS-tab"> 
    <div class="table-responsive">
     <table class="table table-striped table-hover" id="assocRidListTBL">
      <thead>
      <tr>
       <th>RID Number</th>
       <th>RID Status</th>
       <th>Assigned To</th>
       <th>Drug Requested</th>
       <th>Shipment Status</th>
       <th>Request Date</th>
       <th></th>
      </tr>
      </thead>
      <tbody></tbody>
     </table>
    </div>
   </div>
   <div class="tab-pane fade" id="PharmaUsers" role="tabpanel" aria-labelledby="PharmaUsers-tab"> 
    <div id="selectors"></div>
    <div id="results">
     <div class="table-responsive">
      <table class="table table-striped table-hover" id="companyUserListTBL">
       <thead>
       <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Submitted Date</th>
        <th></th>
       </tr>
       </thead>
       <tbody></tbody>
      </table>
     </div>
    </div>
   </div>
  </div>
	</div><!-- end .viewData -->

@endsection

@section('scripts')

	<script type="text/javascript">
		// Data Tables
		$(document).ready(function () {
			$('#companyDrugListTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search")) {
					$(this).text("");
					return;
				}
				var title = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
			});

			var dataTable = $('#companyDrugListTBL').DataTable({
				"paginationDefault": 10,
				// "responsive": true,
				"ajax": {
					url: "{{ route('eac.portal.company.ajax.drug.list', $company->id) }}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{"data": "name", 'name': 'name'},
					{"data": "company_name", 'name': 'company_name'},
					{"data": "status"},
					{"data": "created_at"},
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
				// "responsive": true,
				"ajax": {
					url: "{{ route('eac.portal.company.ajax.rid.list', $company->id) }}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{"data": "number", "name": "number"},
					{"data": "status"},
					{"data": "physician_name", 'name': 'physician_name'},
					{"data": "drug_name", 'name': 'drug_name', orderable: true},
					{"data": "rid_shipment_status"},
					{"data": "created_at", 'name': 'created_at'},
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

	<script type="text/javascript">
		$(document).ready(function () {
			$('#companyUserListTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search")) {
					$(this).text("");
					return;
				}
				var title = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
			});

			var dataTable = $('#companyUserListTBL').DataTable({
				"paginationDefault": 10,
				// "responsive": true,
				"ajax": {
					url: "{{ route('eac.portal.company.ajax.userList', $company->id) }}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				"columns": [
					{"data": "name", "name": "name"},
					{"data": "email"},
					{"data": "status", orderable: false},
					{"data": "created_at", 'name': 'created_at'},
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
