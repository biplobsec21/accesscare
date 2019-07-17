@extends('layouts.portal')

@SetTab('pharmacies')

@section('title')
	All Pharmacies
@endsection
@section('styles')
<style>
.v-inactive{
	display:none ;
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
				<li class="breadcrumb-item active" aria-current="page">
					@yield('title')
				</li>
			</ol>
		</nav>
		<h2 class="m-0">
			@yield('title')
		</h2>
	</div><!-- end .titleBar -->
	@if(Session::has('alerts'))
		{!! view('layouts.alert-dismiss', ['type' => Session::get('alerts')['type'], 'message' => Session::get('alerts')['msg']]) !!}
	@endif
	<div class="actionBar">
		<a href="{{ route('eac.portal.pharmacy.create') }}" class="btn btn-success">
			<i class="fa-fw fas fa-clinic-medical"></i> New Pharmacy
		</a>
		<a href="{{ route('eac.portal.pharmacy.list.merge') }}" class="btn btn-primary">
			<i class="fal fa-code-merge"></i> Merge Pharmacy
		</a>
	</div><!-- end .actionBar -->

	<div class="viewData">
		<div class="card mb-1 mb-md-4">
			<div class="d-flex justify-content-end p-3">
				<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
					<label class="btn btn-secondary btn-sm active" onclick="showactiveOrAll(1)">
						<input type="radio" autocomplete="off"> View Active
					</label>
					<label class="btn btn-secondary   btn-sm" onclick="showactiveOrAll(0)">
						<input type="radio" autocomplete="off" checked> View All
					</label>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover" id="pharmacyTBL">
					<thead>
					<tr>
						<th>Name</th>
						<th class="no-sort no-search">Pharmacists</th>
						<th>Status</th>
						<th>Created At</th>
						<th class="no-sort no-search"></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th>Name</th>
						<th class="no-sort no-search"></th>
						<th>Status</th>
						<th>Created At</th>
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
			$('#pharmacyTBL tfoot th').each(function () {
				if ($(this).hasClass("no-search"))
					return;
				var title = $(this).text();
				$(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
			});

			var dataTable = $('#pharmacyTBL').DataTable({
				"paginationDefault": 10,
				"paginationOptions": [10, 25, 50, 75, 100],
				// "responsive": true,
				// 'order': [[4, 'desc']],
				'order': [[0, 'asc']],
				"ajax": {
					url: "{{route('eac.portal.pharmacy.ajaxlist')}}",
					type: "post"
				},
				"processing": true,
				"serverSide": true,
				columnDefs: [{
					targets: 'no-sort',
					orderable: false,
				}],
				"columns": [
					{"data": "name", 'name': 'name'},
					{"data": "pharmacist_id", 'name': 'pharmacist_id'},
					{"data": "active", 'name': 'active'},
					{"data": "created_at", 'name': 'created_at'},
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

		}); // end doc ready
	</script>
@endsection
