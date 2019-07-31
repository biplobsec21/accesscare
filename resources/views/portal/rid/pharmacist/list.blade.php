@extends('layouts.portal')

@SetTab('pharmacist')

@section('title')
	All Pharmacists
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
	@include('include.alerts')
	<div class="actionBar">
		<a href="{{ route('eac.portal.pharmacist.create') }}" class="btn btn-success">
			<i class="fas fa-user-md fa-fw"></i>  New Pharmacist
		</a>
		<a href="{{ route('eac.portal.pharmacist.list.merge') }}" class="btn btn-primary">
     		<i class="fal fa-code-merge fa-fw"></i> Merge Pharmacist
    	</a>
	</div><!-- end .actionBar -->

	<div class="viewData">
		<div class="card mb-1 mb-md-4">
   <div class="d-flex justify-content-end p-3">
    <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
     <label class="btn btn-secondary btn-sm " onclick="showactiveOrAll(1)">
      <input type="radio"   autocomplete="off"  > View Active
     </label>
     <label class="btn btn-secondary  active btn-sm" onclick="showactiveOrAll(0)">
      <input type="radio"  autocomplete="off" checked> View All
     </label>
    </div>
   </div>
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover" id="pharmacistTBL">
					<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th class="no-search">Status</th>
						<th>Pharmacy</th>
						<th>Last Update</th>
						<th class="no-sort no-search"></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th class="no-search">Status</th>
						<th>Pharmacy</th>
						<th>Last Update</th>
						<th class="no-sort no-search"></th>
					</tr>
					</tfoot>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div><!-- end .viewData -->
@endsection

@section('scripts')
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script>

		$(document).ready(function () {
			$('#pharmacistTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search"))
					return;
				var title = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
				});

				var dataTable = $('#pharmacistTBL').DataTable({
					"paginationDefault": 10,
					"paginationOptions": [10, 25, 50, 75, 100],
					// "responsive": true,
					// 'order': [[4, 'desc']],
					'order': [[0, 'asc']],

					"ajax": {
					url: "{{route('eac.portal.pharmacist.ajaxlist')}}",
						type: "get"
					},
					"processing": true,
					"serverSide": true,
					columnDefs: [{
					targets: 'no-sort',
					orderable: false,
					}],
					"columns": [
						{"data": "name", 'name': 'name'},
						{"data": "email", 'name': 'email'},
						{"data": "phone", 'name': 'phone'},
						{"data": "status", 'name': 'status'},
						{"data": "pharmacy", 'name': 'pharmacy'},
						{"data": "created_at",'name': 'created_at'},
						{"data": "ops_btns"},
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

				$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
				swal({
					title: "Oh Snap!",
					text: "Something went wrong on our side. Please try again later.",
					icon: "warning",
				});
				};

			}); // end doc ready
			$(".alert").delay(2000).slideUp(200, function () {
				$(this).alert('close');
			});
			function showactiveOrAll(param){
     
		     if(param == 1){
		      $('.v-active').show();
		      $('.v-inactive').hide();
		     }
		     if(param == 0){
		      $('.v-active').show();
		      $('.v-inactive').show();
		     }
		    }

	</script>
@endsection
