@extends('layouts.portal')

@section('title')
	All Requests
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
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
		<a href="{{ route('eac.portal.rid.create') }}" class="btn btn-success">
			<i class="fa-fw fas fa-medkit"></i> Initiate Request
		</a>
	</div><!-- end .actionBar -->
 
 <div class="viewData">
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover" id="ridListTBL">
 				<thead>
  				<tr>
  					<th>RID Number</th>
  					<th>Master Status</th>
  					<th>Assigned To</th>
  					<th>Drug Requested</th>
  					<th>Request Date</th>
  					<th>Created At</th>
  					<th></th>
  				</tr>
 				</thead>
 				<tbody></tbody>
 				<tfoot>
  				<tr>
  					<th>RID Number</th>
  					<th class="no-search">Master Status</th>
  					<th>Assigned To</th>
  					<th>Drug Requested</th>
  					<th>Request Date</th>
  					<th>Created At</th>
  					<th class="no-search"></th>
  				</tr>
 				</tfoot>
 			</table>
   </div>
  </div>
 </div><!-- end .viewData -->
@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
	// Data Tables
	$(document).ready(function () {
		$('#ridListTBL tfoot th').each(function () {
			if ($(this).hasClass("no-search")) {
				$(this).text("");
				return;
			}
			var title = $(this).text();
			$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
		});

		var dataTable = $('#ridListTBL').DataTable({
			"paginationDefault": 10,
			"paginationOptions": [10, 25, 50, 75, 100],
			// "responsive": true,
			'order': [[5, 'desc']],
			"ajax": {
				url: "{{route('eac.portal.rid.ajax.statuslist')}}?",// + filter, // json datasource
				type: "post"  // method  , by default get
			},
			"processing": true,
			"serverSide": true,
			"columns": [
				{"data": "number", "name": "number"},
				{"data": "status"},
				{"data": "physician_name"},
				{"data": "drug_name"},
				{"data": "req_date"},
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
@endsection
