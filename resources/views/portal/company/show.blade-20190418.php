@extends('layouts.portal')

@section('styles')
	<style>
		.nav-tab {
			color: black;
			padding: 5px;
		}

		.nav-tab:hover {
			color: #333333;
		}

		.nav-tab.active {
			color: white;
			padding: 5px;
		}

		.nav-tab.active:hover {
			color: #cccccc;
		}
	</style>
@endsection

@section('title')
	View Company
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.company.list') }}">All Companies</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
     Viewing Company: {{ $company->name }} ({{ $company->abbr }})
    </li>
   </ol>
  </nav>
  <h2 class="m-0">
   @yield('title')
  </h2>
 </div><!-- end .titleBar -->


	<div class="actionBar">
		<a href="{{ route("eac.portal.company.edit", $company->id) }}" class="btn btn-primary">
			<i class="far fa-edit"></i> Edit Company
		</a>
		<a href="{{ route("eac.portal.company.list") }}" class="btn btn-warning">
			<i class="fa-fw far fa-building"></i> All Companies
		</a>
	</div><!-- end .actionBar -->

	<div class="viewData">
  <ul class="nav nav-tabs" id="CompanyTabs" role="tablist">
   <li class="nav-item">
    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">
     Company Details
    </a>
   </li>
   <li class="nav-item">
    <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">
     Company Users <span class="badge badge-dark">{{ $company->users->count() }}</span>
    </a>
   </li>
   <li class="nav-item">
    <a class="nav-link" id="rids-tab" data-toggle="tab" href="#rids" role="tab" aria-controls="rids" aria-selected="false">
     Assigned RIDs <span class="badge badge-dark">{{ $company->rids->count() }}</span>
    </a>
   </li>
  </ul>
  <div class="tab-content" id="CompanyTabsContent">
   <div class="tab-pane fade active show" id="details" role="tabpanel" aria-labelledby="details-tab">
    <div class="card card-body mb-3">
     <div class="row">
      <div class="col-md">
       <h5 class="text-gold mb-2">
        Company Information
       </h5>
       <div class="mb-2">
        <label class="d-block">Company Name</label>
        {{ $company->name }}
       </div>
       <div class="mb-2">
        <label class="d-block">Abbreviation</label>
        {{ $company->abbr }}
       </div>
       <div class="mb-2">
        <label class="d-block">Status</label>
        {{ $company->status }}
       </div>
       <div class="mb-2">
        <label class="d-block">Address</label>
        @if(isset($company->address))
         {{ $company->address->addr1 }} <br/>
         @if(isset($company->address->addr2))
          {{ $company->address->addr2 }} <br/>
         @endif
         {{ $company->address->city }}
         , @if($company->address->state){{  $company->address->state->abbr }}@endif {{ $company->address->zipcode }}
         <br/>
         {{ $company->address->country->name }}
        @else
         No Address data.
        @endif
       </div>
       <div class="mb-2">
        <label class="d-block">Company Website</label>
        @if($company->site)
         <a href="http://{{$company->site}}" target="_blank">{{$company->site}}</a>
        @else
         <small class="text-muted">N/A</small>
        @endif
       </div>
      </div>
      <div class="col-md order-md-3">
       <h5 class="text-gold mb-2">
        Company Contacts
       </h5>
       <ul class="list-group list-group-flush">
        <li class="list-group-item list-group-item-light pt-1 pb-1">
         <label>Main</label>
        </li>
        <li class="list-group-item">
         <div>
          <i class="fas fa-phone"></i> <span class="sr-only">Main Phone</span> 
          @if($company->phone_main)
           <a href="tel:{{$company->phone->number}}">{{$company->phone->number}}</a>
          @else
           <small class="text-muted">N/A</small>
          @endif
         </div>
         <div>
          <i class="fas fa-at"></i> <span class="sr-only">Main Email</span> 
          @if($company->email_main)
           <a href="mailto:{{$company->email_main}}">{{$company->email_main}}</a>
          @else
           <small class="text-muted">N/A</small>
          @endif
         </div>
        </li>
        @foreach($company->departments as $department)
         <li class="list-group-item list-group-item-light pt-1 pb-1">
          <label>{{$department->name}}</label>
         </li>
         <li class="list-group-item">
          @if($department->phone_id)
           <div>
            <i class="fas fa-phone"></i> <span class="sr-only">Phone</span>
            <a href="tel:{{$department->phone->number}}">{{$department->phone->number}}</a>
           </div>
          @endif
          @if($department->email)
           <div>
            <i class="fas fa-phone"></i> <span class="sr-only">Email</span>
            <a href="mailto:{{$department->email}}">{{$department->email}}</a>
           </div>
          @endif
         </li>
        @endforeach
       </ul>
      </div>
      <div class="col-md-7 order-md-2">
       <h5 class="text-gold mb-2">
        Submitted Drugs
       </h5>
       <div class="table-responsive">
        <table class="table table-hover table-sm" id="companyDrugListTBL">
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
    </div>

   </div>
   <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
    <div class="card card-body mb-3 p-1">
     <div class="table-responsive">
      <table class="table table-hover table-sm" id="companyUserListTBL">
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
   <div class="tab-pane fade" id="rids" role="tabpanel" aria-labelledby="rids-tab">
    <div class="card card-body mb-3 p-1">
     <div class="table-responsive">
      <table class="table table-hover table-sm" id="assocRidListTBL">
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
     text: "There was an error understanding this request. If this issue persists, <a href="mailto:{{site()->email}}">click her</a> to contact us.",
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
     text: "There was an error understanding this request. If this issue persists, <a href="mailto:{{site()->email}}">click her</a> to contact us.",
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
     text: "There was an error understanding this request. If this issue persists, <a href="mailto:{{site()->email}}">click her</a> to contact us.",
     icon: "warning",
    });
   };

		}); // end doc ready
	</script>

@endsection
